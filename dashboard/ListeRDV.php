<?php
$current = "ListeRDV";

require_once("./navigation.php");
require_once("../PHP_SCRIPT/Utiles.php");
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

            <div class="col-lg-12">
                <div class="main-box no-header clearfix">
                    <div class="main-box-body clearfix">
                        <div class="table-responsive">
                            <table class="table user-list">
                                <thead>
                                    <tr>
                                        <th><span>Nom de patient</span></th>
                                        <th><span>Email </span></th>
                                        <th class=""><span>Téléphone</span></th>
                                        <th><span>Date de rendez-vous</span></th>
                                        <th><span>temps de rendez-vous</span></th>
                                        <th><span>message</span></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="userTable">
                                    <?php if (!empty($array)) {
                                        foreach ($array as $k => $v) { ?>
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
                                                        echo $array[$k]["temp_rdv"];
                                                    }  ?>
                                                </td>
                                                <td>
                                                    <?php echo $array[$k]["message"];  ?>
                                                </td>


                                                <td style="width: 20%;">
                                                    <a href="#" class="table-link text-info" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">
                                                        <span class="fa-stack">
                                                            <i class="fa fa-square fa-stack-2x" data-feather="check"></i>
                                                        </span>
                                                    </a>
                                                    <a href="#" class="table-link danger">
                                                        <span class="fa-stack">
                                                            <i class="fa fa-trash-o fa-stack-1x fa-inverse" data-feather="x-circle"></i>
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

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                                            <input type="text" class="form-control" id="recipient-name">
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Message:</label>
                                            <textarea class="form-control" id="message-text"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Send message</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <?php }
    } ?>