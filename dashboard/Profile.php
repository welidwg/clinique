<?php
$current = "profile";

require_once("./navigation.php");
require_once("../PHP_SCRIPT/Utiles.php");

if ($_SESSION["login"]) {
    $role = Role($_SESSION["role"]);
?>
    <style>
        .card {
            border: none;
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            cursor: pointer;
            -webkit-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -moz-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -o-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -ms-box-shadow: 1px 1px 2px 0 #CCCCCC;
            box-shadow: 1px 1px 9px 0 #CCCCCC;
            height: 35em;

        }

        .card:before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background-color: #E1BEE7;
            transform: scaleY(1);
            transition: all 0.5s;
            transform-origin: bottom
        }

        .card:after {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background-color: #8E24AA;
            transform: scaleY(0);
            transition: all 0.5s;
            transform-origin: bottom
        }

        .card:hover::after {
            transform: scaleY(1)
        }

        .fonts {
            font-size: 11px
        }

        .social-list {
            display: flex;
            list-style: none;
            justify-content: center;
            padding: 0
        }

        .social-list li {
            padding: 10px;
            color: #8E24AA;
            font-size: 19px
        }

        .buttons button:nth-child(1) {
            border: 1px solid #8E24AA !important;
            color: #8E24AA;
            height: 40px
        }

        .buttons button:nth-child(1):hover {
            border: 1px solid #8E24AA !important;
            color: #fff;
            height: 40px;
            background-color: #8E24AA
        }

        .buttons button:nth-child(2) {
            border: 1px solid #8E24AA !important;
            background-color: #8E24AA;
            color: #fff;
            height: 40px
        }
    </style>

    <div class="card ">
        <div class="text-center"> <img src="https://i.imgur.com/bDLhJiP.jpg" width="150" class="rounded-circle"> </div>
        <div class="text-center mt-3"> <span class="bg-secondary p-1 px-4 rounded text-white"><?php echo $_SESSION["nom"]; ?> </span>
            <h5 class="mt-2 mb-0"></h5> <?php echo $role ?><span></span>
            <div class="px-4 mt-3">


                <table class="" style="margin:0 auto;">
                    <tr>
                        <td  style="text-align: right;">
                            <i data-feather="user"></i> &nbsp;&nbsp;
                        </td>
                        <td style="text-align: left;">
                            <?php echo $_SESSION["username"]; ?>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: left;"><i data-feather="mail"></i></td>
                        <td style="text-align: right;"><?php echo $_SESSION["email"]; ?></td>

                    </tr>
                </table>


            </div>
            <ul class="social-list">
                <li><i class="fa fa-facebook" data-feather="facebook"></i></li>
                <li><i class="fa fa-dribbble" data-feather="dribbble"></i></li>
                <li><i class="fa fa-instagram" data-feather="instagram"></i></li>
                <li><i class="fa fa-linkedin" data-feather="linkedin"></i></li>
                <li><i class="fa fa-google" data-feather="github"></i></li>
            </ul>
            <div class="buttons"> <button class="btn btn-outline-primary px-4">Message</button> <button class="btn btn-primary px-4 ms-3">Contact</button> </div>
        </div>
    </div>
    </div>
    </div>
    </div>

<?php
}
