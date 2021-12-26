<?php
$current = "ListeRDV";

require_once("./navigation.php");
require_once("./PHP_SCRIPT/Utiles.php");
$connect = connect_bdd();

if ($_SESSION["login"]) {
    $role = $_SESSION["role"];

    if ($role == 3) {
        $id = GetID();
        $array = runQuery("SELECT * from rendez_vous where id_docteur=$id");


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

            .table tbody tr td button {
                background-color: transparent;
                border: none;
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
        </style>
        <div class="row">
            <input type="text" id="rechercher" class="searchBox" placeholder="Rechercher">
            <script>
                jQuery(function($) {
                    $("#rechercher").on("keyup", function() {
                        Search("rechercher", "userData");
                    })
                })
            </script>

            <div class="col-lg-12" style="zoom: 0.8;">
                <div class="main-box no-header clearfix">
                    <div class="main-box-body clearfix">
                        <div class="table-responsive">
                            <table class="table user-list">
                                <thead>
                                    <tr>
                                        <th><span>Nom de patient</span></th>
                                        <th><span>Email </span></th>
                                        <th class=""><span>Téléphone</span></th>
                                        <th><span>Date </span></th>
                                        <th><span>temps </span></th>
                                        <th><span>message</span></th>
                                        <th><span>status</span></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="userTable">
                                    <?php if (!empty($array)) {
                                        $i = 0;
                                        foreach ($array as $k => $v) {
                                            $i++; ?>
                                            <tr class="userData">
                                                <td>

                                                    <a href="#" class="user-link"><?php echo  $array[$k]["nom_pat"] . "\t";
                                                                                    ?></a>

                                                </td>
                                                <td><?php echo $array[$k]["email_pat"];  ?></td>
                                                <td class="">
                                                    <span class="label label-default"><?php echo $array[$k]["tel_pat"];  ?></span>
                                                </td>
                                                <td>
                                                    <?php echo $array[$k]["date_rdv"];  ?>
                                                </td>
                                                <td>
                                                    <?php if ($array[$k]["temp_rdv"] == "") {
                                                        echo "non encore fixé";
                                                    } else {
                                                        echo date("H:i", strtotime($array[$k]["temp_rdv"]));
                                                    }  ?>
                                                </td>
                                                <td>
                                                    <?php echo $array[$k]["message"];  ?>
                                                </td>
                                                <td style="color:<?php echo StatusColor($array[$k]["status"]) ?>">
                                                    <?php
                                                    echo $array[$k]["status"]; ?>
                                                </td>


                                                <td style="width: 10%;">

                                                    <a class="table-link text-info">
                                                        <?php if ($array[$k]["status"] != "confirme" && $array[$k]["status"] != "depasse") { ?>
                                                            <?php if($array[$k]["status"]!='termine'){ ?>
                                                            <form id="Confirm<?php echo $i ?>">
                                                                <input id="ConfID<?php echo $i ?>" type="hidden" name="id_rendC" value="<?php echo $array[$k]["id_rend"];  ?>">
                                                                <input type="hidden" name="" id="emailPat<?php echo $i; ?>" value="<?php echo $array[$k]["email_pat"];  ?>">
                                                                <button id="test" style="color:green">
                                                                    <i class="fa fa-check"></i>
                                                                </button>
                                                            </form>
                                                            <?php }?>
                                                            <script>
                                                                jQuery(function($) {
                                                                    $("#Confirm<?php echo $i ?>").on('submit', function(e) {
                                                                        e.preventDefault();
                                                                        alertify.prompt('Confirmation du rendez vous', 'Voud devez maintenant affecter un temps pour ce rendez vous :', '0', function(evt, value) {
                                                                                if (value == '') {
                                                                                    evt.cancel = true


                                                                                } else {


                                                                                    $.ajax({
                                                                                        url: "./PHP_SCRIPT/middleware.php",
                                                                                        type: "post",
                                                                                        data: {
                                                                                            id_rendC: $("#ConfID<?php echo $i ?>").val(),
                                                                                            time: value,
                                                                                            mail: $('#emailPat<?php echo $i ?>').val()
                                                                                        },
                                                                                        beforeSend: function() {
                                                                                            // setting a timeout
                                                                                            alertify.warning("Confirmation en cours..");
                                                                                        },
                                                                                        success: function(data) {
                                                                                            if (data == 1) {
                                                                                                alertify.success("Confirmation réussite");
                                                                                                setInterval(() => {
                                                                                                    window.location.reload()
                                                                                                }, 500);
                                                                                            } else if (data == 2) {

                                                                                                alertify.error("tu as déja un rendez vous dans cette heure!");

                                                                                            } else {
                                                                                                alertify.error(data);
                                                                                            }
                                                                                        }


                                                                                    })
                                                                                }
                                                                            },
                                                                            function() {
                                                                                alertify.error('Cancel')
                                                                            }).set("type", "time").set("id", "test");




                                                                    });
                                                                })
                                                            </script>
                                                        <?php } else if ($array[$k]["status"] == "confirme") {
                                                        ?>
                                                            <a class="table-link danger" id="End">
                                                                <span>
                                                                    <form id="End<?php echo $i ?>">
                                                                        <input type="hidden" name="id_rendEnd" value="<?php echo $array[$k]["id_rend"];  ?>">
                                                                        <button style="color:green"> <i class="fa fa-calendar-check"></i></button>
                                                                    </form>
                                                                    <script>
                                                                        jQuery(function($) {

                                                                            $("#End<?php echo $i ?>").on('submit', function(e) {
                                                                                    e.preventDefault();
                                                                                    alertify.confirm('Confirmation', 'Vous confirmez que ce rendez-vous est terminé?', function() {

                                                                                        $.ajax({
                                                                                            url: "./PHP_SCRIPT/middleware.php",
                                                                                            type: "post",
                                                                                            data: $("#End<?php echo $i ?>").serialize(),
                                                                                            success: function(data) {
                                                                                                if (data == 1) {
                                                                                                    alertify.success("Opération effectuée avec succées! ");
                                                                                                    setInterval(() => {
                                                                                                        window.location.reload()
                                                                                                    }, 500);

                                                                                                } else {
                                                                                                    alertify.error(data);
                                                                                                }
                                                                                            }
                                                                                        })
                                                                                    }, function() {
                                                                                        alertify.error('Operation annulée')
                                                                                    });

                                                                                }


                                                                            );




                                                                        });
                                                                    </script>

                                                                </span>
                                                            </a>
                                                        <?php
                                                        } ?>
                                                    </a>
                                                    <a class="table-link danger" id="del">
                                                        <span class="fa-stack">
                                                            <form id="delRdv<?php echo $i ?>">
                                                                <input type="hidden" name="id_rend" value="<?php echo $array[$k]["id_rend"];  ?>">
                                                                <button style="color:red"> <i class="fa fa-trash"></i></button>
                                                            </form>
                                                            <script>
                                                                jQuery(function($) {

                                                                    $("#delRdv<?php echo $i ?>").on('submit', function(e) {
                                                                        e.preventDefault();
                                                                        alertify.confirm('Confirmation', 'Voulez vous vraiment supprimer ce rendez-vous?', function() {

                                                                            $.ajax({
                                                                                url: "./PHP_SCRIPT/middleware.php",
                                                                                type: "post",
                                                                                data: $("#delRdv<?php echo $i ?>").serialize(),
                                                                                success: function(data) {
                                                                                    alertify.success(data);
                                                                                    setInterval(() => {
                                                                                        window.location.reload()
                                                                                    }, 500);
                                                                                }
                                                                            })
                                                                        }, function() {
                                                                            alertify.error('Operation annulée')
                                                                        });



                                                                    });




                                                                });
                                                            </script>

                                                        </span>
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


            <?php }
    } ?>