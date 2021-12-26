<?php
$current = "adduser";

require_once("./navigation.php");
require_once("./PHP_SCRIPT/Utiles.php");
$connect = connect_bdd();

if ($_SESSION["login"] && $_SESSION["role"] == 0) {
    $role = $_SESSION["role"];

    if ($role == 0) {

?>
        <style>
            #adduserform {}

            #adduserform input,
            #adduserform select {
                width: 50%;
                margin: 0 auto;
            }
        </style>
        <script>
            jQuery(function($) {

                var interval = setInterval(function() {
                    Verif()
                }, 1000);



                $('#username').on('keyup', function() {
                    var val = $(this).val();
                    $.ajax({
                        url: "../PHP_SCRIPT/Utiles.php",
                        data: {
                            username: val,
                            query: "AddUser_usrname"
                        },
                        type: "GET",
                        success: function(data) {
                            if (data == 1) {
                                $("#username").css("color", "limegreen");
                                $("#errors").css("display", "none");
                                $("#submit").removeAttr("disabled");
                                $("#usernameErr").css("display", "none");


                            } else {
                                $("#username").css("color", "red");
                                $("#errors").css("display", "block");
                                $("#usernameErr").css("display", "block");
                                $("#submit").attr("disabled", "disabled");
                            }
                        }
                    });
                });
                $('#mail').on('keyup', function() {
                    var val = $(this).val();
                    $.ajax({
                        url: "../PHP_SCRIPT/Utiles.php",
                        data: {
                            mail: val,
                            query: "AddUser_mail"
                        },
                        type: "GET",
                        success: function(data) {
                            if (data == 1) {
                                $("#mail").css("color", "limegreen");
                                $("#errors").css("display", "none");
                                $("#submit").removeAttr("disabled");
                                $("#mailErr").css("display", "none");


                            } else {
                                $("#mail").css("color", "red");
                                $("#errors").css("display", "block");
                                $("#mailErr").css("display", "block");
                                $("#submit").attr("disabled", "disabled");
                            }
                        }
                    });
                });

            })(jQuery);
        </script>
        <style>
            .alert {
                text-align: center;
                width: 60%;
                margin: 0 auto;
                margin-bottom: 5px;
                display: none;
                transition: .5s;
                padding: 1px;
            }

            .alert h6 {
                color: black;
            }
        </style>

        <div class="row">

            <div class="col-12 col-lg-0">

                <div class="card">

                    <div class="card-header">

                        <h5 class="card-title" style="text-align: center;">Ajouter un utilisateur</h5>
                    </div>
                    <div class="card-body">
                        <script>
                            jQuery(function($) {
                                $("#adduserform").on("submit", function(e) {
                                    e.preventDefault();
                                    if ($("#role").val() == "") {
                                        alertify.error("vous devez choisir un rôle");
                                        $("#role").css("border", "1px solid red");
                                    } else {
                                        $("#role").css("border", "1px solid #css");
                                        $.ajax({
                                            type: "post",
                                            url: "PHP_SCRIPT/Auth.php",
                                            data: $(this).serialize(),
                                            success: function(data) {
                                                if (data == 1) {
                                                    alertify.success("Ajouté avec succées");
                                                } else {
                                                    alertify.error(data);

                                                }

                                            }
                                        })



                                    }

                                })
                                $("#adduserform").on("submit", function(e) {
                                    e.preventDefault();

                                })

                                $('#username').on("keyup", function() {
                                    $.ajax({
                                        url: "PHP_SCRIPT/Auth.php",
                                        type: "post",
                                        data: {
                                            query: "username",
                                            data: $(this).val(),
                                        },
                                        success: function(data) {
                                            if (data == 1) {
                                                alertify.error("Nom d''utilisateur déja utilisé!");
                                                $("#username").css("border", "1px solid red");
                                                $('#submit').attr("disabled", true);

                                            } else if (data == 0) {
                                                $("#username").css("border", "1px solid #ccc");
                                                $('#submit').removeAttr("disabled");
                                            }
                                        }
                                    })
                                })
                                $('#mail').on("keyup", function() {
                                    $.ajax({
                                        url: "PHP_SCRIPT/Auth.php",
                                        type: "post",
                                        data: {
                                            query: "email",
                                            data: $(this).val(),
                                        },
                                        success: function(data) {
                                            if (data == 1) {
                                                alertify.error("Email déja utilisé!");
                                                $("#mail").css("border", "1px solid red");
                                                $('#submit').attr("disabled", true);

                                            } else if (data == 0) {
                                                $("#mail").css("border", "1px solid #ccc");
                                                $('#submit').removeAttr("disabled");
                                            }
                                        }
                                    })
                                })


                            })
                        </script>

                        <form id="adduserform" action="" method="POST">

                            <input type="text" name="nom" class="form-control" placeholder="Nom et Prénom " required><br>

                            <input type="text" id="username" name="username" class="form-control" placeholder="Nom d'utilisateur" required> <br>

                            <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" id="mail" name="email" class="form-control" placeholder="Email d'utilisateur" required> <br>

                            <input type="date" max="1999-12-31" name="date" class="form-control" placeholder="Date naissance" required> <br>

                            <select name="role" id="role" class="form-control">
                                <option value="">Rôle d'utilisateur</option>
                                <option value="0">Admin</option>
                                <option value="1">Responsable Stuff</option>

                            </select>
                            <br>
                            <input type="hidden" name="addStuff">

                            <input minlength="5" type="password" name="pswd" class="form-control" placeholder="Mot de passe initial" required> <br>
                            <br>
                            <input id="submit" type="submit" name="ajouter" value="Ajouter" class="form-control" placeholder="Date naissance"> <br>








                        </form>


                    </div>
                </div>
            </div>
            <?php if (isset($_POST["ajouter"])) {

                $username = $_POST["username"];
                $verif_username = verify_user('NomUtilisateur', $username);
                if ($verif_username) {
                    $email = $_POST["email"];
                    $verif_mail = verify_user('Email', $email);
                    if ($verif_mail) {
                        $name = $_POST['nom'];

                        $date = $_POST["date"];

                        $role = $_POST["role"];
                        $mdp = md5($_POST["pswd"]);

                        if (!Insert_User($username, $name, $mdp, $date, $email, $role, NULL, NULL)) {
                            echo mysqli_error($connect);
                            echo  redirect("AddUser?ErreurInconnue");
                        } else {
                            echo  redirect("AddUser?Done");
                        }
                    }
                }
            } ?>







        </div>

<?php }
} ?>