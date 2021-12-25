<?php
$current = "AddStuff";

require_once("./navigation.php");
require_once("./PHP_SCRIPT/Utiles.php");
$connect = connect_bdd();

if ($_SESSION["login"]) {
    $role = $_SESSION["role"];

    if ($role == 1) {

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

                        <h5 class="card-title" style="text-align: center;">Ajouter stuff</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-danger" id="errors">
                            <h6 id="usernameErr" style="display: none;">Nom d'utilisateur déja existant ! </h6>
                            <h6 id="mailErr" style="display: none;">Email déja existant ! </h6>

                        </div>
                        <div class="alert alert-success" id="success" <?php if (isset($_GET["Done"])) {
                                                                            echo "style='display:block'";
                                                                        } ?>>
                            <p id="Done">Utilisateur est ajouté avec succées! </p>

                        </div>
                        <form id="adduserform" action="" method="POST">

                            <input type="text" name="nom" class="form-control" placeholder="Nom et Prénom " required><br>

                            <input type="text" id="username" name="username" class="form-control" placeholder="Nom d'utilisateur" required> <br>

                            <input type="email" id="mail" name="email" class="form-control" placeholder="Email d'utilisateur" required> <br>

                            <input type="date" name="date" class="form-control" placeholder="Date naissance" required> <br>

                            <select name="role" id="" class="form-control">
                                <option value="">Rôle de stuff</option>
                                <option value="3">Docteur</option>
                                <option value="4">Infirmier</option>

                            </select>
                            <br>
                            <select name="dept" id="" class="form-control">
                                <option value="">Choisissez le departement</option>
                                <?php $array = runQuery("SELECT * from departement");
                                if (!empty($array)) {
                                    foreach ($array as $k => $v) { ?>
                                        <option value="<?php echo $array[$k]["id_dep"]  ?>"><?php echo $array[$k]["nom_dep"]  ?></option>
                                <?php }
                                } ?>
                            </select>
                            <br>
                            <input type="password" name="pswd" class="form-control" placeholder="Mot de passe initial" required> <br>
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
                        $dept=$_POST["dept"];
                        $mdp = md5($_POST["pswd"]);

                        if (!Insert_User($username, $name, $mdp, $date, $email, $role, NULL,$dept)) {
                            echo mysqli_error($connect);
                            echo  redirect("AddStuff?ErreurInconnue");
                        } else {
                            echo  redirect("AddStuff?Done");
                        }
                    }
                }
            } ?>







        </div>

<?php  }
} ?>