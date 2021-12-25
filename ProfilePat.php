<?php
if (isset($_SESSION["role"])) {
    $role = $_SESSION["role"];
    require_once("./PHP_SCRIPT/Utiles.php");
    $user = getuserdata($_SESSION["idUser"]);

    $connect = connect_bdd();
    $nom = GetNom();
    $email = GetEmail();
    $roleUser = Role($role);
    $username = GetUsername();


?>
    <html lang="en">


    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="assets/img/Clinique.png" />
        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
        <script src="assets/js/jQuery.js"></script>

    </head>
    <style>
        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8
        }

        .profile-button {
            background: rgb(99, 39, 120);
            box-shadow: none;
            border: none
        }

        .profile-button:hover {
            background: #682773
        }

        .profile-button:focus {
            background: #682773;
            box-shadow: none
        }

        .profile-button:active {
            background: #682773;
            box-shadow: none
        }

        .back:hover {
            color: #682773;
            cursor: pointer
        }

        .labels {
            font-size: 13px
        }

        .labels button {
            font-size: 11px;
            border: none;
            color: darkred;
            background-color: transparent;
        }

        .add-experience:hover {
            background: #BA68C8;
            color: #fff;
            cursor: pointer;
            border: solid 1px #BA68C8
        }
    </style>
    <script>
        jQuery(function($) {

            $('#confirmation').on("keyup", function() {
                if ($(this).val() !== $("#mdp").val()) {
                    $('#sub').attr("disabled", true);
                    $(this).css("border", "1px solid red");

                } else {
                    $(this).css("border", "1px solid limegreen");
                    $('#sub').removeAttr("disabled");


                }
            })


            $('#emailPr').on("keyup", function() {
                $.ajax({
                    type: 'post',
                    url: './PHP_SCRIPT/Auth.php',
                    data: {
                        query: "emailProfile",
                        data: $(this).val(),

                    },
                    success: function(data) {
                        console.log(data)
                        if (data == 1) {
                            $('#emailPr').css("border", "1px solid red")
                            alertify.error("Email déja existant");
                            $('#sub').attr("disabled", true);
                        } else {
                            $('#sub').removeAttr("disabled");
                            $('#emailPr').css("border", "1px solid limegreen")
                        }
                    },
                    error: function() {
                        alertify.error("error");
                    }
                });
            })
            $('#tel').on("keyup", function() {
                $.ajax({
                    type: 'post',
                    url: './PHP_SCRIPT/middleware.php',
                    data: {
                        query: "tel",
                        data: $(this).val(),

                    },
                    success: function(data) {
                        console.log(data)
                        if (data == 1) {
                            $('#tel').css("border", "1px solid red")
                            alertify.error("Numero de telephone déja existant");
                            $('#sub').attr("disabled", true);
                        } else {
                            $('#sub').removeAttr("disabled");
                            $('#tel').css("border", "1px solid limegreen")
                        }
                    },
                    error: function() {
                        alertify.error("error");
                    }
                });
            })


            $("#editprofile").on("submit", function(e) {
                e.preventDefault();
                var form = $(this)[0];
                var formData = new FormData(form);
                $.ajax({
                    type: "post",
                    url: "./PHP_SCRIPT/middleware.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data == 1) {
                            alertify.success("Modification enregistrée");
                            $("#editprofile").trigger("reset")

                        } else {
                            alertify.error(data)
                        }

                    }
                })
            })



        })
    </script>

    <body>
        <div class="container rounded bg-white mt-5 mb-5" style="zoom:0.9">
            <div class="row" style="border-radius: 12px;box-shadow: 2px 5px 8px 2px rgba(0, 0, 0, 0.5);">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center  py-5" style="padding: 10px;"><img class="rounded-circle mt-7" width="220px" id="avatarProf" src="<?php echo $_SESSION["avatar"]; ?>"><span id="nameP" class="font-weight-bold"><?php echo $_SESSION["nom"] ?></span><span class="text-black-50"><?php echo Role($_SESSION["role"]) ?></span><span> </span></div>
                </div>
                <div class="<?php if ($role == 2) {
                                echo "col-md-4";
                            } else {
                                echo "col-md-8";
                            } ?> border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile</h4>
                        </div>
                        <form id="editprofile" enctype="multipart/form-data">
                            <div class="row mt-2">
                                <div class="col-md-6"><label class="labels">Nom et prenom</label><input type="text" class="form-control" id="nomPrenom" name="name" value="<?php echo $_SESSION["nom"] ?>" required></div>
                                <div class="col-md-6"><label class="labels">Nom d'utilisateur</label><input type="text" class="form-control" value="<?php echo $_SESSION["username"] ?>" placeholder="surname" readonly></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12"><label class="labels">Email</label><input id="emailPr" type="email" name="email" class="form-control" placeholder="" value="<?php echo $_SESSION["email"] ?>" required></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12"><label class="labels">Telephone : </label><input type="tel" id="tel" name="tel" class="form-control" placeholder="" value="<?php echo $_SESSION["tel"] ?>"></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12"><label class="labels">Votre avatar : </label><input type="file" id="" name="avatar" class="form-control" placeholder=""></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12"><label class="labels">Date de naissance</label><input type="date" id="dateP" name="datenaiss" class="form-control" placeholder="" value="<?php echo $_SESSION["datenaiss"] ?>" required></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6"><label class="labels">Nouveau Mot de passe :</label><input id="mdp" name="mdp" type="password" class="form-control" placeholder="Mot de passe" value="" min="5"></div>
                                <div class="col-md-6"><label class="labels">Confirmer Mot de passe :</label><input id="confirmation" type="password" class="form-control" value="" placeholder="Confirmer" min="5"></div>

                            </div>
                            <input type="hidden" name="edit">
                            <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit" id="sub">Enregitrer</button></div>
                        </form>
                    </div>

                </div>
                <?php if ($role == 2) { ?>
                    <div class="col-md-4">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center experience"><span>Liste des rendez-vous</span></div><br>
                            <?php
                            $id = $_SESSION['idUser'];
                            $array = runQuery("SELECT * from rendez_vous where id_pat like $id ");
                            $i = 0;
                            if (!empty($array)) {
                                foreach ($array as $k => $v) {
                                    $i++; ?>
                                    <div class="col-md-12">
                                        <label class="labels"><strong>Date:</strong> <?php echo date("d-m-Y", strtotime($array[$k]["date_rdv"])) ?></label><br>
                                        <label class="labels" for=""><strong>Docteur:</strong> <?php echo GetNameByID($array[$k]["id_docteur"]); ?></label><br>
                                        <label class="labels" for=""><strong>Heure:</strong> <?php if ($array[$k]["temp_rdv"] == "") {
                                                                                                    echo "non encore palinifié";
                                                                                                } else {
                                                                                                    echo date("H:i", strtotime($array[$k]["temp_rdv"]));
                                                                                                } ?></label><br>
                                        <label class="labels" for=""><strong>Status :</strong> <span style="color: <?php $status = $array[$k]["status"];
                                                                                                                    echo StatusColor($status) ?>;"><?php
                                                                                                                                                    echo $array[$k]["status"] ?></span> </label><br>
                                        <label for="" class="labels"><strong>Action :</strong>
                                            <form style="display: inline-block;" id="FormDel<?php echo $i ?>"><input type="hidden" value="<?php echo $array[$k]["id_rend"]  ?>" id="DeleteRdv<?php echo $i ?>" name="PatDelRdv"> <button type="submit"><i class="fa fa-trash"></i></button></form>
                                        </label>
                                        <script>
                                            jQuery(function($) {
                                                $('#FormDel<?php echo $i ?>').on("submit", function(e) {
                                                    e.preventDefault();
                                                    alertify.confirm("Confirmer la Supression", "Voulez vous supprimez ce rendez-vous ?", function() {
                                                        $.ajax({
                                                            url: "./PHP_SCRIPT/middleware.php",
                                                            type: "post",
                                                            data: {
                                                                idrendDEL: $("#DeleteRdv<?php echo $i ?>").val()
                                                            },
                                                            success: function(data) {
                                                                if (data == 1) {
                                                                    alertify.success("Suppression réussite ! ")

                                                                } else {
                                                                    alertify.error(data)
                                                                }

                                                            }
                                                        })
                                                    }, function() {
                                                        alertify.error("Opération annulée")
                                                    })

                                                })
                                            })
                                        </script>
                                    </div>
                                    <hr>
                            <?php }
                            } else {
                                echo "aucun rendez-vous pour le moment";
                            } ?>
                        </div>
                    </div>
                <?php } ?>

            </div>
            <script>
                jQuery(function($) {
                    function refresh() {
                        $.ajax({
                            url: './PHP_SCRIPT/Auth.php',
                            type: "POST",
                            data: {
                                query: "refresh_Session",
                                id: <?php echo $_SESSION["idUser"] ?>
                            },
                            dataType: "json",
                            success: function(data) {
                                $("#nomUSR").html("").append(data.nom + '<?php echo  " : " . Role($role) . "" ?>');
                                $("#avaTop").attr("src", "" + data.avatar);
                                $("#avatarProf").attr("src", "" + data.avatar);
                                $("#nomPrenom").attr("value", "" + data.nom);
                                $("#emailPr").attr("value", "" + data.email);
                                $("#tel").attr("value", "" + data.tel);
                                $("#dateP").attr("value", "" + data.datenaiss);
                                $("#nameP").html("").append(data.nom)
                            }
                        })
                    }
                    setInterval(() => {
                        refresh()
                    }, 500);
                })
            </script>
        </div>
        </div>
        </div>
        <!--  <div class="page-content page-container" id="page-content">

                <div class="card user-card-full" style="width: 100%;">

                    <div class="row m-l-0 m-r-0" style="height: auto;">

                        <div class="col-sm-4 bg-c-lite-green user-profile" style="width: 280px;">

                            <div class="card-block text-center text-white" style="margin-top: 150px;">
                                <div class="m-b-25"> <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image"> </div>
                                <h6 class="f-w-600"><?php echo $nom ?></h6>
                                <p><?php echo $role ?></p> <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-block" style="height:fit-content">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Email</p>
                                        <h6 class="text-muted f-w-400"><?php echo $email; ?></h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">nom d'utilisateur</p>
                                        <h6 class="text-muted f-w-400"><?php echo $username; ?></h6>
                                    </div>
                                </div>
                                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Listes des Rendez-vous</h6>
                                <div class="row" style="max-height: 400px;overflow: auto;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">First</th>
                                                <th scope="col">Last</th>
                                                <th scope="col">Handle</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>@twitter</td>
                                            </tr>
                                            <tr>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>@twitter</td>
                                            </tr>
                                            <tr>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>@twitter</td>
                                            </tr>
                                            <tr>
                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>@mdo</td>
                                            </tr>
                                            <tr>
                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>@fat</td>
                                            </tr>
                                            <tr>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>@twitter</td>
                                            </tr>
                                            <tr>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>@twitter</td>
                                            </tr>
                                            <tr>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>@twitter</td>
                                            </tr>
                                           
                                        </tbody>
                                    </table>
                                </div>
                                <ul class="social-link list-unstyled m-t-40 m-b-10">
                                    <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="facebook" data-abc="true"><i class="mdi mdi-facebook feather icon-facebook facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="twitter" data-abc="true"><i class="mdi mdi-twitter feather icon-twitter twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="instagram" data-abc="true"><i class="mdi mdi-instagram feather icon-instagram instagram" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
            </div> -->
    </body>

    </html>
<?php
} ?>