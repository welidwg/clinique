<?php
$current = "userList";

require_once("./navigation.php");
require_once("../PHP_SCRIPT/Utiles.php");

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
                                    <?php if (!empty($array)) {
                                        foreach ($array as $k => $v) { ?>
                                            <tr class="userData">
                                                <td>
                                                    <img src="<?php if (!empty($array[$k]["Avatar"])) {
                                                                    echo $array[$k]['Avatar'];
                                                                } else {
                                                                    echo "../assets/img/avatars/0.png";
                                                                } ?>" style="border-radius: 50px;" alt="">
                                                    <a href="#" class="user-link"><?php echo  $array[$k]["Nom"] . "\t";
                                                                                    if ($array[$k]["Nom"] == $_SESSION["nom"]) echo "(Moi)"; ?></a>
                                                    <span class="user-subhead"><?php
                                                                                echo Role($array[$k]["Role"]);
                                                                                ?></span>
                                                </td>
                                                <td><?php echo $array[$k]["Email"];  ?></td>
                                                <td class="">
                                                    <span class="label label-default"><?php echo $array[$k]["NomUtilisateur"];  ?></span>
                                                </td>

                                                <td style="width: 20%;">
                                                    <a href="#" class="table-link text-info">
                                                        <span class="fa-stack">
                                                            <i class="fa fa-square fa-stack-2x" data-feather="edit"></i>
                                                        </span>
                                                    </a>
                                                    <a href="#" class="table-link danger">
                                                        <span class="fa-stack">
                                                            <i class="fa fa-trash-o fa-stack-1x fa-inverse" data-feather="trash"></i>
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

                    <script>
                        function Search(IDinput, ClassItem) {
                            var input = document.getElementById(IDinput);
                            var filter = input.value.toLowerCase();
                            var element = document.getElementsByClassName(ClassItem);



                            for (i = 0; i < element.length; i++) {

                                if (element[i].innerText.toLowerCase().includes(filter)) {
                                    element[i].style.display = "table-row";

                                } else {
                                    element[i].style.display = "none";

                                }

                            }

                        }


                        document.getElementById("rechercher").oninput = function() {
                            Search('rechercher', 'userData');


                        };
                    </script>
                </div>
            </div>
        </div>
    </div>

<?php } ?>