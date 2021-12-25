<?php
$current = "profile";

require_once("./navigation.php");
require_once("./PHP_SCRIPT/Utiles.php");
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

    <body>
        <main id="main">

            <section class="container"><?php
                                        include_once("./ProfilePat.php");
                                        ?></section>
        </main>
    </body>




<?php
}
