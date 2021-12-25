<?php
$current = "departList";
require_once("./navigation.php");
require_once("./PHP_SCRIPT/Utiles.php");
if (isset($_SESSION["login"]) && $_SESSION["role"] == 0) {

?>

    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liste des departements</title>
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

        $array = runQuery("SELECT * from departement  ORDER BY id_dep asc ");


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
                                            <th><span>Id </span></th>
                                            <th><span>Nom de departement</span></th>
                                            <th><span>description</span></th>
                                            <th class=""><span>Action</span></th>



                                        </tr>
                                    </thead>
                                    <tbody id="userTable">
                                        <?php
                                        $i = 0;
                                        if (!empty($array)) {
                                            foreach ($array as $k => $v) {
                                                $i++; ?>
                                                <tr class="userData">
                                                    <td style="width: 10%;">
                                                        <a href="#" class="user-link"><?php echo  $array[$k]["id_dep"] . "\t";
                                                                                        ?></a>

                                                    </td>
                                                    <td style="width:20%"><?php echo $array[$k]["nom_dep"];  ?></td>
                                                    <td style="width:30%">
                                                        <p style=""><?php echo $array[$k]["description"];  ?></p>
                                                    </td>


                                                    <td style="width: 15%;">
                                                        <a id="openF<?php echo $i ?>" class="table-link text-info">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a class="table-link danger">
                                                            <form style="display: inline-block;" id="deletedept<?php echo $i ?>">
                                                                <input type="hidden" id="deptID<?php echo $i ?>" value="<?php echo  $array[$k]["id_dep"]; ?>" name="test">
                                                                <button style="color:red">
                                                                    <i class="fa fa-trash"></i>

                                                                </button>
                                                            </form>

                                                            <script>
                                                                jQuery(function($) {

                                                                    $("#openF<?php echo $i ?>").on('click', function() {
                                                                        $.ajax({
                                                                            url: "./PHP_SCRIPT/middleware.php",
                                                                            type: "post",
                                                                            dataType: "json",
                                                                            data: {
                                                                                query: "editDept",
                                                                                id: $("#deptID<?php echo $i ?>").val()

                                                                            },
                                                                            success: function(data) {

                                                                                $("#Auth").css("display", "block");
                                                                                $("#nomDept").attr("value", data.nom);
                                                                                $("#iddept").attr("value", data.id);
                                                                                $("#descDept").attr("value", data.desc);
                                                                                $("#deptpic").attr("value", data.image);






                                                                            },
                                                                            error: function(request, status, error) {
                                                                                alertify.error(request.responseText)
                                                                            }

                                                                        })

                                                                    })



                                                                    $("#deletedept<?php echo $i ?>").on("submit", function(e) {
                                                                        e.preventDefault();
                                                                        alertify.confirm("Confirmer Supression", 'Voulez vous supprimer ce departement?', function() {
                                                                            $.ajax({
                                                                                url: "./PHP_SCRIPT/middleware.php",
                                                                                type: "post",
                                                                                data: {
                                                                                    query: "deptDelete",
                                                                                    id: $("#deptID<?php echo $i ?>").val()
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
                                    <form id="modification" enctype="multipart/form-data">
                                        <h1>Modifier Departement</h1>
                                        <label for=""> Nom de departement</label>
                                        <input id="nomDept" type="text" name="nomdeptE" required="">
                                        <label for=""> Description</label>
                                        <input id="descDept" type="text" name="descdept">
                                        <label for=""> Image : </label>
                                        <input id="" type="file" name="pic">
                                        <input type="hidden" name="deptpic" id="deptpic">
                                        <input type="hidden" id="iddept" name="idDeptEDIT">
                                        <button id="sub" name="save">Enregistrer</button>
                                    </form>
                                    <script>
                                        jQuery(function($) {

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
    </body>

    </html>


<?php
}
