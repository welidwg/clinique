<?php
$current = "MedList";
require_once("./navigation.php");
require_once("./PHP_SCRIPT/Utiles.php");
if (isset($_SESSION["login"])) {
    if ($_SESSION["role"] == 4 || $_SESSION["role"] == 3) {
?>

        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Liste des Médicaments</title>
        </head>

        <body>
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
                }

                .table thead tr th {
                    border-bottom: 2px solid #e7ebee;
                    text-align: center;
                    width: 10%;
                }





                .table tbody tr td {
                    font-size: 1.125em;
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

                input[type="radio"] {
                    width: 10%;
                    display: inline-block;
                    background-color: none;
                    box-shadow: none;
                }
            </style>


            <?php

            $array = runQuery("SELECT * from pharmacie  ORDER BY code  asc ");


            ?>

            <div class="container bootstrap snippets bootdey">

                <div class="row">
                    <input type="text" id="rechercher" class="searchBox" placeholder="Rechercher">
                    <style>
                        a {
                            text-decoration: none;

                        }

                        * {
                            text-align: left;
                        }
                    </style>
                    <div class="col-lg-12" style="zoom: 0.8;">
                        <div class="main-box no-header clearfix">
                            <div class="main-box-body clearfix">
                                <div class="table-responsive">
                                    <table class="table user-list">
                                        <thead>
                                            <tr>
                                                <th><span>Code </span></th>
                                                <th><span>libellé</span></th>
                                                <th><span>stock</span></th>
                                                <?php if ($_SESSION["role"] == 4) { ?> <th class=""><span>Action</span></th> <?php } ?>



                                            </tr>
                                        </thead>
                                        <tbody id="userTable">
                                            <?php
                                            $i = 0;
                                            if (!empty($array)) {
                                                foreach ($array as $k => $v) {
                                                    $i++; ?>
                                                    <tr class="userData">
                                                        <td style="width: 5%; text-align: center;">
                                                            <a href="#" class=""><?php echo  $array[$k]["code"] . "\t";
                                                                                    ?></a>

                                                        </td>
                                                        <td><?php echo $array[$k]["nom"];  ?></td>
                                                        <td style="width: 5%;text-align: center;">
                                                            <?php echo $array[$k]["stock"];  ?>
                                                        </td>

                                                        <?php if ($_SESSION["role"] == 4) { ?>
                                                            <td>
                                                                <a id="openF<?php echo $i ?>" class="table-link text-info">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <a class="table-link danger">
                                                                    <form style="display: inline-block;" id="deleteMed<?php echo $i ?>">
                                                                        <input type="hidden" id="MedID<?php echo $i ?>" value="<?php echo  $array[$k]["id"]; ?>" name="test">
                                                                        <button style="color:red">
                                                                            <i class="fa fa-trash"></i>

                                                                        </button>
                                                                    </form>

                                                                    <script>
                                                                        jQuery(function($) {

                                                                            $("#openF<?php echo $i ?>").on('click', function() {
                                                                                openForm();

                                                                                $.ajax({
                                                                                    url: "./PHP_SCRIPT/middleware.php",
                                                                                    type: "post",
                                                                                    dataType: "json",
                                                                                    data: {
                                                                                        query: "editMed",
                                                                                        id: $("#MedID<?php echo $i ?>").val()

                                                                                    },
                                                                                    success: function(data) {

                                                                                        $("#nom").attr("value", data.nom);
                                                                                        $("#id").attr("value", data.id);
                                                                                        $("#code").attr("value", data.code);
                                                                                        $("#stockH").attr("value", data.stock);
                                                                                        $("#idMedEdit").attr("value", data.id);







                                                                                    },
                                                                                    error: function(request, status, error) {
                                                                                        alertify.error(request.responseText)
                                                                                        console.error(request.responseText);
                                                                                    }

                                                                                })

                                                                            })



                                                                            $("#deleteMed<?php echo $i ?>").on("submit", function(e) {
                                                                                e.preventDefault();
                                                                                alertify.confirm("Confirmer Supression", 'Voulez vous supprimer ce Medicament?', function() {
                                                                                    $.ajax({
                                                                                        url: "./PHP_SCRIPT/middleware.php",
                                                                                        type: "post",
                                                                                        data: {
                                                                                            query: "MedDelete",
                                                                                            id: $("#MedID<?php echo $i ?>").val()
                                                                                        },
                                                                                        success: function(data) {
                                                                                            if (data == 1) {
                                                                                                alertify.success("Suppression réussite !")
                                                                                                setInterval(() => {
                                                                                                    window.location.reload()
                                                                                                }, 500);
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
                                                        <?php } ?>
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
                                        <form id="modification" enctype="multipart/form-data" style="color:white">
                                            <h1>Modifier Medicament</h1>

                                            <label for=""> Nom</label>
                                            <input minlength="5" id="nom" type="text" name="nom">
                                            <label for=""> Action : </label>
                                            <input id="action1" style="color:white" type="radio" name="action" value="1" required>Ajout
                                            <input id="action2" type="radio" name="action" value="0" required>Réduction
                                            <input id="action3" type="radio" name="action" value="2" required>Rien
                                            <br>
                                            <input style="display: none;" min="0" type="number" id="stock" name="stock">
                                            <input type="hidden" id="id" name="idMedEdit">
                                            <input type="hidden" id="stockH" name="stockH">
                                            <button id="sub" name="save">Enregistrer</button>
                                        </form>
                                        <script>
                                            jQuery(function($) {
                                                $('input:radio[name="action"]').change(
                                                    function() {
                                                        if (this.checked && this.value == '0') {
                                                            let max = $("#stockH").val();
                                                            $('#stock').attr("max", max);
                                                            $("#stock").css("display", "block");


                                                        } else if (this.checked && this.value == '1') {
                                                            $('#stock').removeAttr("max");
                                                            $("#stock").css("display", "block");


                                                        } else if (this.checked && this.value == '2') {
                                                            $("#stock").css("display", "none");
                                                        }
                                                    });


                                                $("#modification").on("submit", function(e) {
                                                    e.preventDefault();
                                                    var form = $(this)[0];
                                                    var formData = new FormData(form);
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "./PHP_SCRIPT/middleware.php",
                                                        data: formData,
                                                        processData: false,
                                                        contentType: false,
                                                        success: function(data) {
                                                            if (data == 1) {
                                                                alertify.success("Modification enregistrée");
                                                                closeForm();
                                                                setInterval(() => {
                                                                    window.location.reload()
                                                                }, 500);
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
                                document.getElementById("rechercher").oninput = function() {
                                    Search('rechercher', 'userData');


                                };
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </body>

        </html>


<?php

    }
}
