<?php
session_start();
if (isset($_SESSION["role"])) {
    $role = $_SESSION["role"];
    require_once("./PHP_SCRIPT/Utiles.php");

    if ($role == 2) {
        $connect = connect_bdd();
        $nom = GetNom();
        $email = GetEmail();
        $role = Role($role);
        $username = GetUsername();


?>
        <html lang="en">


        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="shortcut icon" href="assets/img/Clinique.png" />
            <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
            <title>Profile | <?php echo $nom ?></title>
        </head>
        <style>
            body {
                background-color: #f9f9fa;
                overflow: hidden;
            }

            .padding {
                padding: 3rem !important
            }

            .user-card-full {
                overflow: hidden
            }

            .card {
                border-radius: 5px;
                -webkit-box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
                box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
                border: none;
                margin-bottom: 30px
            }

            .m-r-0 {
                margin-right: 0px
            }

            .m-l-0 {
                margin-left: 0px
            }

            .user-card-full .user-profile {
                border-radius: 5px 0 0 5px
            }

            .bg-c-lite-green {
                background: -webkit-gradient(linear, left top, right top, from(#296870), to(#2fced6));
                background: linear-gradient(to right, #2fced6, #296870)
            }

            .user-profile {
                padding: 20px 0
            }

            .card-block {
                padding: 1.25rem
            }

            .m-b-25 {
                margin-bottom: 25px
            }

            .img-radius {
                border-radius: 5px
            }

            h6 {
                font-size: 14px
            }

            .card .card-block p {
                line-height: 25px
            }

            @media only screen and (min-width: 1400px) {
                p {
                    font-size: 14px
                }
            }

            .card-block {
                padding: 1.25rem
            }

            .b-b-default {
                border-bottom: 1px solid #e0e0e0
            }

            .m-b-20 {
                margin-bottom: 20px
            }

            .p-b-5 {
                padding-bottom: 5px !important
            }

            .card .card-block p {
                line-height: 25px
            }

            .m-b-10 {
                margin-bottom: 10px
            }

            .text-muted {
                color: #919aa3 !important
            }

            .b-b-default {
                border-bottom: 1px solid #e0e0e0
            }

            .f-w-600 {
                font-weight: 600
            }

            .m-b-20 {
                margin-bottom: 20px
            }

            .m-t-40 {
                margin-top: 20px
            }

            .p-b-5 {
                padding-bottom: 5px !important
            }

            .m-b-10 {
                margin-bottom: 10px
            }

            .m-t-40 {
                margin-top: 20px
            }

            .user-card-full .social-link li {
                display: inline-block
            }

            .user-card-full .social-link li a {
                font-size: 20px;
                margin: 0 10px 0 0;
                -webkit-transition: all 0.3s ease-in-out;
                transition: all 0.3s ease-in-out
            }
        </style>

        <body>
            <div class="page-content page-container" id="page-content">

                <div class="card user-card-full" style="width: 100%;">

                    <div class="row m-l-0 m-r-0" style="height: 50em;">

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
            </div>
        </body>

        </html>
<?php }
} ?>