<?php
$current = "userList";

require_once("./navigation.php");
require_once("./PHP_SCRIPT/Utiles.php");

if ($_SESSION["role"] == 0 || $_SESSION["role"] == 1) {
    $role = $_SESSION["role"];
?>

    <style>
        .main-box.no-header {
            padding-top: 20px;
        }

        .main-box {
            background: #FFFFFF;
            -webkit-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -moz-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -o-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -ms-box-shadow: 1px 1px 2px 0 #CCCCCC;
            box-shadow: 1px 1px 9px 0 #CCCCCC;
            margin-bottom: 16px;
            -webikt-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            border-radius: 20px;
        }

        .table a.table-link.danger {
            color: #e74c3c;
        }

        .label {
            border-radius: 3px;
            font-size: 0.9em;
            font-weight: 600;
        }

        .user-list tbody td .user-subhead {
            font-size: 0.9em;
            font-style: italic;
        }

        .user-list tbody td .user-link {
            display: block;
            font-size: 1em;
            padding-top: 3px;
            margin-left: 60px;
        }

        a {
            color: #3498db;
            outline: none !important;
        }

        .user-list tbody td>img {
            position: relative;
            max-width: 50px;
            float: left;
            margin-right: 15px;
        }

        .table thead tr th {
            text-transform: uppercase;
            font-size: 0.875em;
            text-align: center;
        }

        .table thead tr th {
            border-bottom: 2px solid #e7ebee;
        }

        .table tbody tr td:first-child {
            font-size: 1.125em;
            font-weight: 300;
            text-align: left;
        }

        .table thead tr th:first-child {
            text-align: left;
            padding-left: 50px;
        }

        .table tbody tr td {
            font-size: 1.125em;
            vertical-align: middle;
            border-top: 1px solid #e7ebee;
            padding: 12px 8px;
            text-align: center;
        }

        a:hover {
            text-decoration: none;
        }

        .searchBox {
            border-radius: 10px;
            padding: 10px;
            margin: 0 auto;
            margin-bottom: 19px;
            width: 60%;
            background: white;
            -webkit-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -moz-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -o-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -ms-box-shadow: 1px 1px 2px 0 #CCCCCC;
            box-shadow: 1px 1px 9px 0 #CCCCCC;
            border: unset
        }

        .searchBox:focus {
            transition: .2s;
            color: black;
            outline: unset;

        }

        .table tbody tr td button {
            background-color: transparent;
            border: none;
        }
    </style>


    <?php
    if ($role == 0) {
        $array = runQuery("SELECT * from users ORDER BY role asc ");
    } else {
        $array = runQuery("SELECT * from users where Role like 3 or Role like 4  ORDER BY role asc ");
    }

    ?>

    <div class="container bootstrap snippets bootdey">

        <div class="row">
            <input type="text" id="rechercher" class="searchBox" placeholder="Rechercher">

            <div class="col-lg-12">
                <div class="main-box no-header clearfix">
                    <div class="main-box-body clearfix">
                        <div class="table-responsive">
                            <table class="table user-list">
                                <thead>
                                    <tr>
                                        <th><span>Nom & Type</span></th>
                                        <th><span>Email</span></th>
                                        <th class=""><span>Nom d'utilisateur</span></th>



                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="userTable">
                                    <?php
                                    $i = 0;
                                    if (!empty($array)) {
                                        foreach ($array as $k => $v) {
                                            $i++; ?>
                                            <tr class="userData">
                                                <td>
                                                    <img src="<?php if (!empty($array[$k]["Avatar"])) {
                                                                    echo $array[$k]['Avatar'];
                                                                } else {
                                                                    echo "../assets/img/avatars/0.png";
                                                                } ?>" style="border-radius: 50px;" alt="">
                                                    <a href="#" class="user-link"><?php echo  $array[$k]["Nom"] . "\t";
                                                                                    if ($array[$k]["Nom"] == $_SESSION["nom"]) echo "(Moi)<br>"; ?></a>
                                                    <span class="user-subhead"><?php
                                                                                if ($array[$k]["Role"] == 3) {
                                                                                    echo Role($array[$k]["Role"]) . " (" . getDeptName($array[$k]["id_dep"]) . ")";
                                                                                } else {
                                                                                    echo Role($array[$k]["Role"]);
                                                                                }
                                                                                ?></span>
                                                </td>
                                                <td><?php echo $array[$k]["Email"];  ?></td>
                                                <td class="">
                                                    <span class="label label-default"><?php echo $array[$k]["NomUtilisateur"];  ?></span>
                                                </td>

                                                <td style="width: 20%;">
                                                    <a id="openF<?php echo $i ?>" style="text-decoration: none;" class="table-link text-info">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a class="table-link danger">
                                                        <form style="display: inline-block;" id="deleteuser<?php echo $i ?>">
                                                            <input type="hidden" id="userID<?php echo $i ?>" value="<?php echo  $array[$k]["userID"]; ?>" name="test">
                                                            <button style="color:red">
                                                                <i class="fa fa-trash"></i>

                                                            </button>
                                                        </form>

                                                        <script>
                                                            jQuery(function($) {
                                                                function verifRole() {
                                                                    if ($("#selectRole").val() == 3) {
                                                                        $("#deptHidden").css("display", "block");

                                                                    } else {
                                                                        $("#deptHidden").css("display", "none");
                                                                    }
                                                                }
                                                                setInterval(() => {
                                                                    verifRole();

                                                                }, 100);

                                                                /*$("#selectRole").on("change", function() {


                                                                })*/
                                                                $("#openF<?php echo $i ?>").on('click', function() {
                                                                    $.ajax({
                                                                        url: "./PHP_SCRIPT/middleware.php",
                                                                        type: "post",
                                                                        data: {
                                                                            query: "editUser",
                                                                            id: $("#userID<?php echo $i ?>").val()

                                                                        },
                                                                        dataType: "json",
                                                                        success: function(data) {

                                                                            $("#Auth").css("display", "block");
                                                                            $("#email").attr("value", data.email);
                                                                            $("#date").attr("value", data.datenaiss);
                                                                            $("#role").attr("value", data.role)
                                                                            $("#nomE").attr("value", data.nom)
                                                                            $("#role").html("").append(data.role_name)
                                                                            $("#iduser").attr("value", data.id)

                                                                            $("#departement").html("")
                                                                            console.log(data.dept.length);
                                                                            if (data.id_dep != 0) {
                                                                                $("#departement").append("<option value='" + data.id_dep + "'>" + data.nom_dep + "</option>")

                                                                            }
                                                                            for (let i = 0; i < data.dept.length; i++) {
                                                                                $("#departement").append("<option value='" + data.dept[i].id_dep + "'>" + data.dept[i].nom_dep + "</option>")
                                                                            }





                                                                            if (data.role == 0) {
                                                                                $("#selectRole").html('')
                                                                                $("#selectRole").append("<option value='0'>Admin</option>")
                                                                                <?php if ($_SESSION["role"] == 0) { ?>
                                                                                    $("#selectRole").append("<option value='1'>Responsable Stuff</option>");
                                                                                    $("#selectRole").append("<option value='2'>Patient</option>");
                                                                                    $("#selectRole").append("<option value='3'>Docteur</option>");
                                                                                    $("#selectRole").append("<option value='4'>Pharmacien</option>");
                                                                                <?php  } else { ?>
                                                                                    $("#selectRole").append("<option value='3'>Docteur</option>");
                                                                                    $("#selectRole").append("<option value='4'>Pharmacien</option>");
                                                                                <?php } ?>

                                                                            } else if (data.role == 1) {
                                                                                $("#selectRole").html('')
                                                                                $("#selectRole").append("<option value='1'>Responsable Stuff</option>")
                                                                                $("#selectRole").append("<option value='0'>Admin</option>");
                                                                                $("#selectRole").append("<option value='2'>Patient</option>");
                                                                                $("#selectRole").append("<option value='3'>Docteur</option>");
                                                                                $("#selectRole").append("<option value='4'>Pharmacien</option>");

                                                                            } else if (data.role == 2) {
                                                                                $("#selectRole").html('')
                                                                                $("#selectRole").append("<option value='2'>Patient</option>")
                                                                                $("#selectRole").append("<option value='0'>Admin</option>");
                                                                                $("#selectRole").append("<option value='1'>Responsable Stuff</option>");
                                                                                $("#selectRole").append("<option value='3'>Docteur</option>");
                                                                                $("#selectRole").append("<option value='4'>Pharmacien</option>");
                                                                            } else if (data.role == 3) {
                                                                                $("#selectRole").html('')

                                                                                $("#selectRole").append("<option value='3'>Docteur</option>")
                                                                                <?php if ($_SESSION["role"] == 0) { ?>
                                                                                    $("#selectRole").append("<option value='0'>Admin</option>");
                                                                                    $("#selectRole").append("<option value='1'>Responsable Stuff</option>");
                                                                                    $("#selectRole").append("<option value='2'>Patient</option>");
                                                                                <?php } ?>
                                                                                $("#selectRole").append("<option value='4'>Pharmacien</option>");
                                                                            } else if (data.role == 4) {
                                                                                $("#selectRole").html('')
                                                                                $("#selectRole").append("<option value='4'>Pharmacien</option>");
                                                                                $("#selectRole").append("<option value='3'>Docteur</option>")
                                                                                <?php if ($_SESSION["role"] == 0) { ?>
                                                                                    $("#selectRole").append("<option value='0'>Admin</option>");
                                                                                    $("#selectRole").append("<option value='1'>Responsable Stuff</option>");
                                                                                    $("#selectRole").append("<option value='2'>Patient</option>");
                                                                                <?php } ?>
                                                                            }


                                                                        },
                                                                        error: function(request, status, error) {
                                                                            alertify.error(request.responseText)
                                                                        }

                                                                    })

                                                                })



                                                                $("#deleteuser<?php echo $i ?>").on("submit", function(e) {
                                                                    e.preventDefault();
                                                                    alertify.confirm("Confirmer Supression", 'Voulez vous supprimer ce utilisateur?', function() {
                                                                        $.ajax({
                                                                            url: "./PHP_SCRIPT/middleware.php",
                                                                            type: "post",
                                                                            data: {
                                                                                query: "userDelete",
                                                                                id: $("#userID<?php echo $i ?>").val()
                                                                            },
                                                                            success: function(data) {
                                                                                if (data == 1) {
                                                                                    alertify.success("Suppression réussite !");
                                                                                    setInterval(() => {

                                                                                        window.location.reload();
                                                                                    }, 700);
                                                                                } else {
                                                                                    alertify.error(data)

                                                                                }
                                                                            }
                                                                        });
                                                                    }, function() {
                                                                        alertify.error("Opération annulée")
                                                                    });

                                                                })
                                                            })
                                                        </script>
                                                    </a>
                                                </td>
                                            </tr>
                                    <?php }
                                    } else {
                                        echo "aucun enregistrement";
                                    } ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <script>
                        function openForm() {
                            var modal = document.getElementById("Auth");
                            modal.style.display = "block"

                        }

                        function closeForm() {
                            var modal = document.getElementById("Auth");
                            modal.style.display = "none"
                        }

                        back = document.getElementsById("Auth");

                        span = document.getElementsByClassName("close");
                        span.onclick = closeForm();
                    </script>
                    <div id="Auth" class="modal">

                        <!-- Modal content -->
                        <div class="modal-content1">
                            <div class="mainM">
                                <span onclick="closeForm()" class="close">x</span>
                                <form id="modification">
                                    <h1>Modifier utilisateur</h1>
                                    <label for=""> Nom et prénom</label>
                                    <input minlength="5" id="nomE" type="text" name="nom" required="">
                                    <label for=""> Date de naissance</label>
                                    <input max="1999-12-31" type="date" id="date" name="datenaiss" placeholder="Date De naissance" required="">
                                    <label for=""> Email</label>
                                    <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" type="email" name="email" placeholder="Email" required="" id="email">
                                    <label for=""> Rôle :</label>
                                    <select name="role" id="selectRole" class="form-select">
                                        <option id="role"></option>
                                    </select>
                                    <div id="deptHidden" style="display: none;">
                                        <label for="">Departement</label>
                                        <select name="departement" id="departement" class="form-select">
                                            <option value="">Selectionnez un département</option>

                                        </select>
                                    </div>
                                    <input type="hidden" id="iduser" name="iduserEDIT">
                                    <button id="sub" name="save">Enregistrer</button>
                                </form>
                                <script>
                                    jQuery(function($) {

                                        $("#email").on("keyup", function() {
                                            $.ajax({
                                                type: "post",
                                                url: "./PHP_SCRIPT/Auth.php",
                                                data: {
                                                    query: "emailModif",
                                                    email: $(this).val(),
                                                    idUser: $("#iduser").val()
                                                },
                                                success: function(data) {
                                                    if (data != 0) {
                                                        $("#sub").attr("disabled", true)
                                                        $("#email").css("border", "1px solid red")
                                                        alertify.error("Cet email est déja utlisé !")

                                                    } else {
                                                        $("#sub").removeAttr("disabled")
                                                        $("#email").css("border", "1px solid limegreen")
                                                    }
                                                }
                                            })
                                        })
                                        $("#modification").on("submit", function(e) {
                                            e.preventDefault()
                                            $.ajax({
                                                type: "POST",
                                                url: "./PHP_SCRIPT/middleware.php",
                                                data: $(this).serialize(),
                                                success: function(data) {
                                                    if (data == 1) {
                                                        alertify.success("Modification enregistrée");
                                                        closeForm();
                                                        setInterval(() => {
                                                            window.location.reload()
                                                        }, 700);
                                                    } else {
                                                        alertify.error(data)
                                                    }
                                                }
                                            })


                                        })
                                    })
                                </script>

                            </div>
                        </div>
                    </div>
                    <script>
                        jQuery(function($) {


                        });
                        document.getElementById("rechercher").oninput = function() {
                            Search('rechercher', 'userData');


                        };
                    </script>
                </div>
            </div>
        </div>
    </div>

<?php } ?>