<?php
session_start();
require_once("./PHP_SCRIPT/Utiles.php");

if (isset($_SESSION["role"])) {
  $role = $_SESSION["role"];
  $connect = connect_bdd();
}

if (!isset($_SESSION["login"]) || $role == 2) {
  if (isset($role)) {
    $nom = $_SESSION["username"];
    $username = $_SESSION["username"];
  } ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Clinique</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/Clinique.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="assets/fa/css/all.css">
    <script src="assets/js/jQuery.js"></script>



    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <script src="./assets/Alertify/alertify.js"></script>
    <script src="./assets/Alertify/alertify.min.js"></script>
    <link rel="stylesheet" href="./assets/Alertify/css/alertify.min.css">
    <link rel="stylesheet" href="./assets/Alertify/css/alertify.css">
    <script>
      alertify.defaults.transition = "slide";
      alertify.defaults.theme.ok = "btn btn-primary";
      alertify.defaults.theme.cancel = "btn btn-danger";
      alertify.defaults.theme.input = "form-control";
    </script>

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Medilab - v4.6.0
  * Template URL: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  </head>

  <body>


    <!-- ======= Top Bar ======= -->
    <div id="topbar" class="d-flex align-items-center fixed-top">
      <div class="container d-flex ">
        <div class="contact-info d-flex ">
        </div>
        <?php if (!isset($_SESSION["login"])) { ?>

          <div class="cord">
            <form class="items" id="loginForm">
              <input type="email" name="email" id="" require placeholder="Email">&nbsp;
              <input type="password" name="pswd" id="" required placeholder="Mot de passe">&nbsp;
              <input type="hidden" name="LogForm">
              <button type="submit" name="Login"><i class="fa fa-sign-in-alt"></i></button> &nbsp;&nbsp;
              <a id="forget">Mot de passe oublié ?</a>


            </form>



          </div>
          <script>
            jQuery(function($) {
              if (localStorage.getItem("code") == localStorage.getItem("code2") && localStorage.getItem("code") != undefined) {
                alertify.prompt("Nouveau mot de passe", "Saisir attentivement votre nouveau mot de passe : ", '', function(e, v) {
                  if (v == '' || v.length < 4) {
                    e.cancel = true;
                    alertify.error("Entrez un mot de passe valide !")
                  } else {
                    $.ajax({
                      url: "./PHP_SCRIPT/Auth.php",
                      type: "post",
                      data: {
                        query: "ChangePass",
                        data: v,
                        email: localStorage.getItem("email")
                      },
                      success: function(data) {
                        if (data == 1) {
                          alertify.success("Mot de passe bien récupérée");
                          localStorage.removeItem("code");
                          localStorage.removeItem("code2");
                          localStorage.removeItem("email");
                        } else {
                          alertify.error(data);
                        }
                      }
                    })
                  }


                }, function() {
                  alertify.error("Operation annulée");

                }).set("type", "password");
              }


              $("#forget").on("click", function() {
                alertify.prompt('Confirmation ', 'Voud devez entrer votre email :', '', function(evt, value) {
                    if (value == '') {
                      evt.cancel = true


                    } else {
                      $.ajax({
                        url: "./PHP_SCRIPT/Auth.php",
                        type: "post",
                        data: {
                          query: "email",
                          data: value,
                        },
                        success: function(data) {
                          if (data == 0) {
                            alertify.error("Email n'existe pas");
                          } else {
                            $.ajax({
                              url: "./PHP_SCRIPT/Auth.php",
                              type: "post",
                              data: {
                                query: "Forget",
                                email: value,
                              },
                              beforeSend: function() {
                                // setting a timeout
                                alertify.warning("Verification en cours..");
                              },
                              success: function(data) {

                                localStorage.setItem("email", value)
                                localStorage.setItem("code", data);
                                alertify.prompt("Validation", "Un code est envoyée à votre email , saisir le code reçu s'il vous plaît : ", '', function(e, val) {
                                  if (val == '') {
                                    e.cancel = true
                                  } else {
                                    let cd = localStorage.getItem("code");
                                    if (val != cd) {
                                      e.cancel = true;
                                      alertify.error("code non valide");
                                    } else {
                                      localStorage.setItem("code2", val);
                                      window.location.reload();



                                    }

                                  }
                                }, function() {
                                  alertify.error('Operation annulée')
                                  localStorage.removeItem("code");
                                })

                              }


                            })
                          }

                        }




                      })
                    }
                  },
                  function() {
                    alertify.error('Cancel')
                  }).set("type", "email")




              });
            })

            $('#loginForm').on('submit', function(e) {
              e.preventDefault();
              $.ajax({
                type: "post",
                url: "./PHP_SCRIPT/Auth.php",
                data: $(this).serialize(),
                success: function(data) {
                  if (data == "notfound") {
                    alertify.error("Verifier vos cordonnées")

                  } else if (data == "pass") {
                    alertify.error("mot de passe non valide")

                  } else {
                    window.location.reload()
                  }

                }
              })
            });
          </script>
        <?php } else { ?>
          <div class="back" id="back" style="position: absolute;left:15px;top:10px;display:none;font-size: 15px;">
            <a href="./index" style="text-decoration: none;"><i class="fa fa-arrow-circle-left"></i> Retourner</a>
          </div>
          <div class="cord">
            <div class="items">
              <img id="avaTop" src="<?php echo $_SESSION["avatar"] ?>" alt="">&nbsp;
              <span id="nomUSR"><?php echo $_SESSION["nom"] . " : " . Role($role) . "" ?></span>&nbsp;
              <button style="background-color: rgba(223, 72, 72, 0.888);" type="submit" id="logout"><i class="fa fa-sign-out-alt"></i></button> &nbsp;&nbsp;


            </div>

          </div>

        <?php } ?>
      </div>
    </div>
    </div>
    <script>
      jQuery(function($) {
        $("#goProfile").on("click", function() {
          $("#profile").css("display", "block");
          $('#mainContent').css("display", "none");
          $('#back').css("display", "block");

        });
        $("#logout").on("click", function() {
          window.location.href = "./PHP_SCRIPT/Utiles.php?Logout";
        });
      })
    </script>
    <!-- ======= Header ======= -->
    <?php if (isset($role)) { ?>
      <div id="profile" style="display: none;">

        <main id="main">
          <section class="container"><?php include_once("./ProfilePat.php");
                                      ?></section>
        </main>
      </div>
    <?php } ?>
    <div id="mainContent">

      <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">

          <h1 style="width: 300px;margin-left:-80px"><a href="index"><img src="./assets/img/Clinique.png" alt="" style="width: 100px;height:90px;"></a></h1>
          <!-- Uncomment below if you prefer to use an image logo -->
          <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

          <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
              <li><a class="nav-link scrollto active" href="#hero">Accueil</a></li>
              <li><a class="nav-link scrollto" href="#about">A propos</a></li>
              <li><a class="nav-link scrollto" href="#services">Nos Services</a></li>
              <?php if (isset($_SESSION['login'])) {
                if ($_SESSION["role"] == 2) { ?>
                  <li><a class="nav-link scrollto" href="#appointment">Prendre rendez-vous</a></li>
              <?php }
              } ?>
              <li><a class="nav-link scrollto" href="#departments">Nos Departements</a></li>
              <li><a class="nav-link scrollto" href="#doctors">Nos Docteurs</a></li>
              <!-- <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li>-->
              <li><a class="nav-link scrollto" href="#contact">Contactez-nous</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
          </nav><!-- .navbar -->
          <?php if (isset($role)) { ?> <a class="appointment-btn scrollto" id="goProfile" href="#profile"><span class="d-none d-md-inline"><i class="fa fa-user"></i>&nbsp;</span>Profile</a> <?php } ?>
          <?php if (!isset($_SESSION["login"])) { ?>
            <a class="appointment-btn scrollto" id="conn" onclick="openForm()"><span class="d-none d-md-inline">Joignez</span>-nous </a> <?php } ?>
        </div>

      </header><!-- End Header -->

      <!-- ======= Hero Section ======= -->
      <section id="hero" class="d-flex align-items-center">
        <div class="container">
          <h1>Bienvenue à Clinique</h1>
          <h2>Nous somme à votre service 7/7 jours et 24/24 heures</h2>
          <a href="#about" class="btn-get-started scrollto">Commencer</a>
        </div>
      </section><!-- End Hero -->

      <main id="main">

        <!-- ======= Why Us Section ======= -->
        <section id="why-us" class="why-us">
          <div class="container">

            <div class="row">
              <div class="col-lg-4 d-flex align-items-stretch">
                <div class="content">
                  <h3>Pourquoi choisir clinique ?</h3>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit
                    Asperiores dolores sed et. Tenetur quia eos. Autem tempore quibusdam vel necessitatibus optio ad corporis.
                  </p>
                  <div class="text-center">
                    <a href="#" class="more-btn">Plus <i class="bx bx-chevron-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-8 d-flex align-items-stretch">
                <div class="icon-boxes d-flex flex-column justify-content-center">
                  <div class="row">
                    <div class="col-xl-4 d-flex align-items-stretch">
                      <div class="icon-box mt-4 mt-xl-0">
                        <i class="bx bx-receipt"></i>
                        <h4>Corporis voluptates sit</h4>
                        <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip</p>
                      </div>
                    </div>
                    <div class="col-xl-4 d-flex align-items-stretch">
                      <div class="icon-box mt-4 mt-xl-0">
                        <i class="bx bx-cube-alt"></i>
                        <h4>Ullamco laboris ladore pan</h4>
                        <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>
                      </div>
                    </div>
                    <div class="col-xl-4 d-flex align-items-stretch">
                      <div class="icon-box mt-4 mt-xl-0">
                        <i class="bx bx-images"></i>
                        <h4>Labore consequatur</h4>
                        <p>Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere</p>
                      </div>
                    </div>
                  </div>
                </div><!-- End .content-->
              </div>
            </div>

          </div>
        </section><!-- End Why Us Section -->

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
          <div class="container-fluid">

            <div class="row">
              <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch position-relative">
                <a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="glightbox play-btn mb-4"></a>
              </div>

              <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                <h3>A propos de notre clinique</h3>
                <p>Esse voluptas cumque vel exercitationem. Reiciendis est hic accusamus. Non ipsam et sed minima temporibus laudantium. Soluta voluptate sed facere corporis dolores excepturi. Libero laboriosam sint et id nulla tenetur. Suscipit aut voluptate.</p>

                <div class="icon-box">
                  <div class="icon"><i class="bx bx-fingerprint"></i></div>
                  <h4 class="title"><a href="">Lorem Ipsum</a></h4>
                  <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident</p>
                </div>

                <div class="icon-box">
                  <div class="icon"><i class="bx bx-gift"></i></div>
                  <h4 class="title"><a href="">Nemo Enim</a></h4>
                  <p class="description">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque</p>
                </div>

                <div class="icon-box">
                  <div class="icon"><i class="bx bx-atom"></i></div>
                  <h4 class="title"><a href="">Dine Pad</a></h4>
                  <p class="description">Explicabo est voluptatum asperiores consequatur magnam. Et veritatis odit. Sunt aut deserunt minus aut eligendi omnis</p>
                </div>

              </div>
            </div>

          </div>
        </section><!-- End About Section -->

        <!-- ======= Counts Section ======= -->
        <section id="counts" class="counts">
          <div class="container">

            <div class="row">

              <div class="col-lg-3 col-md-6">
                <div class="count-box">
                  <i class="fas fa-user-md"></i>
                  <span data-purecounter-start="0" data-purecounter-end="85" data-purecounter-duration="1" class="purecounter"></span>
                  <p>Docteurs</p>
                </div>
              </div>

              <div class="col-lg-3 col-md-6 mt-5 mt-md-0">
                <div class="count-box">
                  <i class="far fa-hospital"></i>
                  <span data-purecounter-start="0" data-purecounter-end="18" data-purecounter-duration="1" class="purecounter"></span>
                  <p>Departements</p>
                </div>
              </div>

              <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                <div class="count-box">
                  <i class="fas fa-flask"></i>
                  <span data-purecounter-start="0" data-purecounter-end="12" data-purecounter-duration="1" class="purecounter"></span>
                  <p>Laboratoires de recherche</p>
                </div>
              </div>

              <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                <div class="count-box">
                  <i class="fas fa-award"></i>
                  <span data-purecounter-start="0" data-purecounter-end="150" data-purecounter-duration="1" class="purecounter"></span>
                  <p>Prix</p>
                </div>
              </div>

            </div>

          </div>
        </section><!-- End Counts Section -->

        <!-- ======= Services Section ======= -->
        <section id="services" class="services">
          <div class="container">

            <div class="section-title">
              <h2>Nos Services</h2>
              <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
            </div>

            <div class="row">
              <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                <div class="icon-box">
                  <div class="icon"><i class="fas fa-heartbeat"></i></div>
                  <h4><a href="">Lorem Ipsum</a></h4>
                  <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                <div class="icon-box">
                  <div class="icon"><i class="fas fa-pills"></i></div>
                  <h4><a href="">Sed ut perspiciatis</a></h4>
                  <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
                <div class="icon-box">
                  <div class="icon"><i class="fas fa-hospital-user"></i></div>
                  <h4><a href="">Magni Dolores</a></h4>
                  <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                <div class="icon-box">
                  <div class="icon"><i class="fas fa-dna"></i></div>
                  <h4><a href="">Nemo Enim</a></h4>
                  <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis</p>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                <div class="icon-box">
                  <div class="icon"><i class="fas fa-wheelchair"></i></div>
                  <h4><a href="">Dele cardo</a></h4>
                  <p>Quis consequatur saepe eligendi voluptatem consequatur dolor consequuntur</p>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                <div class="icon-box">
                  <div class="icon"><i class="fas fa-notes-medical"></i></div>
                  <h4><a href="">Divera don</a></h4>
                  <p>Modi nostrum vel laborum. Porro fugit error sit minus sapiente sit aspernatur</p>
                </div>
              </div>

            </div>

          </div>
        </section>
        <!-- End Services Section -->

        <div id="Auth" class="modal">

          <!-- Modal content -->
          <div class="modal-content1">
            <div class="mainM">
              <span onclick="closeForm()" class="close">x</span>
              <form id="inscription" enctype="multipart/form-data" method="POST">
                <h1>Crée un compte</h1>
                <label for=""> Nom d'utilisateur</label>
                <input minlength="5" type="text" id="username" name="nomUtilisateur" placeholder="Nom d'utilisateur" required="">
                <label for=""> Nom et prénom</label>
                <input minlength="6" type="text" name="nom" placeholder="Votre Nom" required="">
                <label for=""> Date de naissance</label>
                <input max="1999-12-31" type="date" name="datenaissance" placeholder="Date De naissance" required="">
                <label for=""> Email</label>
                <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" type="email" name="email" placeholder="Email" required="" id="emailI">
                <label for=""> Mot de passe</label>
                <input minlength="5" type="password" name="motdepasse" placeholder="Mot de passe" required="">
                <label for=""> Photo de profile </label>
                <input style="font-size:10px;padding-top: 4px;height:30px" type="file" name="AVATAR" value="">
                <input type="hidden" name="sign">
                <button id="sub" name="SignUp">S'inscrire</button>
              </form>

            </div>
            <style>
              .alertify-notifier .ajs-message.ajs-error,
              .alertify-notifier .ajs-message.ajs-success {
                color: white;
              }
            </style>
            <script>
              jQuery(function($) {
                setInterval(() => {
                  VerifStatus()
                }, 2000);

                function VerifStatus() {
                  $.ajax({
                    url: "./PHP_SCRIPT/middleware.php",
                    type: "post",
                    data: {
                      query: "verifStatus"
                    },
                    success: function(data) {
                      if (data == "done") {
                        alertify.error(data)

                      }

                    }
                  })
                }
                $("#inscription").on('submit', function(e) {
                  e.preventDefault();
                  var form = $(this)[0];
                  var formData = new FormData(form);


                  $.ajax({
                    type: 'POST',
                    url: './PHP_SCRIPT/Auth.php',

                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                      if (data == "1") {
                        alertify.success("Inscription reussite.");
                        $('#inscription').trigger("reset");
                      } else {
                        alertify.error(data)
                      }
                    },
                    error: function() {
                      alert("error");
                    }
                  });
                });
                $('#username').on("keyup", function() {
                  $.ajax({
                    type: 'post',
                    url: './PHP_SCRIPT/Auth.php',
                    data: {
                      query: "username",
                      data: $(this).val()
                    },
                    success: function(data) {
                      if (data == 1) {
                        $('#username').css("color", "red")
                        alertify.error("Nom d'utilisateur déja existant");


                        $('#sub').attr("disabled", true);
                      } else {
                        $('#sub').removeAttr("disabled");
                        $('#username').css("color", "black")
                      }
                    },
                    error: function() {
                      alertify.error("error");
                    }
                  });
                })
                $('#emailI').on("keyup", function() {
                  $.ajax({
                    type: 'post',
                    url: './PHP_SCRIPT/Auth.php',
                    data: {
                      query: "email",
                      data: $(this).val()
                    },
                    success: function(data) {
                      if (data == 1) {
                        $('#emailI').css("color", "red")
                        alertify.error("Email déja existant");
                        $('#sub').attr("disabled", true);
                      } else {
                        $('#sub').removeAttr("disabled");
                        $('#emailI').css("color", "black")
                      }
                    },
                    error: function() {
                      alertify.error("error");
                    }
                  });
                })



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
              });
            </script>


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

        <?php if (isset($_SESSION["login"])) {
          if ($_SESSION["role"] == "2") { ?>
            <!-- ======= Appointment Section ======= -->
            <section id="appointment" class="appointment section-bg">
              <div class="container">

                <div class="section-title">
                  <h2>Prendre rendez-vous</h2>
                </div>
                <script>
                  jQuery(function($) {
                    $('#rendform').on("submit", function(e) {
                      e.preventDefault();
                      $.ajax({
                        type: "post",
                        url: "./PHP_SCRIPT/middleware.php",
                        data: $(this).serialize(),
                        success: function(data) {
                          if (data == 1) {
                            alertify.success("Rendez vous bien envoyée,veuillez attendre un email de confirmation");
                            $('#rendform').trigger("reset");
                          } else if (data == 0) {
                            alertify.error("Vous avez déja demander un rendez vous dans cette date ! ");


                          } else {
                            alertify.error(data);

                          }

                        }
                      })

                    })
                  });
                </script>

                <form role="form" class="php-email-form" id="rendform">
                  <div class="row">
                    <input type="hidden" name="formRes">
                    <div class="col-md-4 form-group">
                      <input type="text" name="name" disabled value="<?php echo $_SESSION["nom"]; ?>" class="form-control" id="name" placeholder="Votre nom complet" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                      <div class="validate"></div>
                    </div>
                    <div class="col-md-4 form-group mt-3 mt-md-0">
                      <input required type="email" class="form-control" disabled value="<?php echo $_SESSION["email"]; ?>" name="email" id="email" placeholder="Votre email" data-rule="email" data-msg="Please enter a valid email">
                      <div class="validate"></div>
                    </div>
                    <div class="col-md-4 form-group mt-3 mt-md-0">
                      <input required type="tel" class="form-control" required name="tel" id="phone" placeholder="Votre numéro portable" <?php if ($_SESSION["tel"] != "") {
                                                                                                                                            echo "readonly value='" . $_SESSION["tel"] . "'";
                                                                                                                                          } ?>>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 form-group mt-3">
                      <input required type="date" min="<?php echo date("Y-m-d") ?>" name="date" class="form-control datepicker" id="date" placeholder="Date de rendez-vous" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
                      <div class="validate"></div>
                    </div>
                    <div class="col-md-4 form-group mt-3">
                      <select name="departement" id="department" class="form-select">
                        <option value="">Selectionnez un département</option>
                        <?php
                        $array = runQuery("SELECT * from departement");
                        if (!empty($array)) {
                          foreach ($array as $k => $v) {


                        ?>
                            <option value="<?php echo $array[$k]["id_dep"]; ?>"><?php echo $array[$k]["nom_dep"]; ?></option>
                        <?php }
                        } ?>
                      </select>

                      <div class="validate"></div>
                    </div>
                    <div class="col-md-4 form-group mt-3">
                      <select name="doctor" id="doctor" class="form-select">
                        <option value="">Selectionnez un docteur</option>

                      </select>


                      <div class="validate"></div>
                    </div>
                  </div>
                  <script>
                    $('#department').on('change', function() {
                      var val = $(this).val();
                      $.ajax({
                        url: "PHP_SCRIPT/Utiles.php",
                        data: {
                          id_dept: val,
                          query: "doctors"
                        },
                        type: "GET",
                        dataType: "json",



                        success: function(data) {
                          if (data != 0) {
                            for (var i = 0; i < data.length; i++) {
                              $('#doctor').empty().append("<option value='" + data[i].id_doc + "'>" + data[i].nom + "</option>");
                              $('#doctor').removeAttr("disabled")
                              $('#confirm').removeAttr("disabled")

                            }
                          } else {
                            $('#doctor').empty().append("<option> aucun docteur pour le moment </option>")
                            $('#doctor').attr("disabled", "disabled")
                            $("#confirm").attr("disabled", "disabled")

                          }


                        }
                      });
                    });
                  </script>
                  <?php if (isset($_POST["data"])) {
                    echo "ok" . $_POST["data"];
                  } ?>

                  <div class="form-group mt-3">
                    <textarea class="form-control" name="message" rows="5" placeholder="Message (Optionel)"></textarea>
                    <div class="validate"></div>
                  </div>
                  <div class="mb-3">
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                  </div>
                  <div class="text-center"><button id="confirm" name="confirm" type="submit">Confirmer</button></div>
                </form>


              </div>
            </section><!-- End Appointment Section -->
        <?php }
        } ?>

        <!-- ======= Departments Section ======= -->
        <section id="departments" class="departments">
          <div class="container">
            <div class="section-title">
              <h2>Departements</h2>
              <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
            </div>

            <div class="row">
              <div class="col-lg-3">
                <ul class="nav nav-tabs flex-column">
                  <?php
                  $i = 0;
                  $arr = runQuery("SELECT * from departement order by nom_dep asc");
                  if (!empty($arr)) {
                    foreach ($arr as $key => $val) {
                      $i++; ?>
                      <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-<?php echo $i ?>"><?php echo $arr[$key]["nom_dep"] ?>
                        </a>
                      </li>
                  <?php }
                  } ?>

                </ul>
              </div>
              <div class="col-lg-9 mt-4 mt-lg-0">
                <div class="tab-content">
                  <?php
                  $i = 0;
                  $arr1 = runQuery("SELECT * from departement order by nom_dep asc");
                  if (!empty($arr)) {
                    foreach ($arr as $ke => $va) {
                      $i++; ?>
                      <div class="tab-pane <?php if ($i == 1) {
                                              echo "active";
                                            } ?> " id="tab-<?php echo $i; ?>">
                        <div class="row">
                          <div class="col-lg-8 details order-2 order-lg-1">
                            <h3><?php echo $arr1[$ke]["nom_dep"] ?></h3>
                            <p class="fst-italic"><?php
                                                  echo $arr1[$ke]["description"]; ?></p>
                          </div>
                          <div class="col-lg-4 text-center order-1 order-lg-2">
                            <img src="<?php echo $arr1[$ke]["image"] ?>" alt="image" class="img-fluid">
                          </div>
                        </div>
                      </div>
                  <?php }
                  } ?>





                </div>
              </div>
            </div>

          </div>
        </section><!-- End Departments Section -->

        <!-- ======= Doctors Section ======= -->
        <section id="doctors" class="doctors">
          <div class="container">

            <div class="section-title">
              <h2>Nos Docteurs</h2>
              <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
            </div>

            <div class="row">
              <?php $doc = runQuery("SELECT * from users where Role=3");
              if (!empty($doc)) {
                foreach ($doc as $a => $n) { ?>
                  <div class="col-lg-6">
                    <div class="member d-flex align-items-start">
                      <div class="pic"><img src="<?php echo $doc[$a]["Avatar"] ?>" class="img-fluid" alt=""></div>
                      <div class="member-info">
                        <h4><?php echo $doc[$a]["Nom"] ?></h4>
                        <span><?php echo getDeptName($doc[$a]["id_dep"]) ?></span>
                        <p>Explicabo voluptatem mollitia et repellat qui dolorum quasi</p>
                        <div class="social">
                          <a href=""><i class="ri-twitter-fill"></i></a>
                          <a href=""><i class="ri-facebook-fill"></i></a>
                          <a href=""><i class="ri-instagram-fill"></i></a>
                          <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                        </div>
                      </div>
                    </div>
                  </div>
              <?php }
              } ?>

              <!--<div class="col-lg-6 mt-4 mt-lg-0">
                <div class="member d-flex align-items-start">
                  <div class="pic"><img src="assets/img/doctors/doctors-2.jpg" class="img-fluid" alt=""></div>
                  <div class="member-info">
                    <h4>Sarah Jhonson</h4>
                    <span>Anesthesiologist</span>
                    <p>Aut maiores voluptates amet et quis praesentium qui senda para</p>
                    <div class="social">
                      <a href=""><i class="ri-twitter-fill"></i></a>
                      <a href=""><i class="ri-facebook-fill"></i></a>
                      <a href=""><i class="ri-instagram-fill"></i></a>
                      <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-6 mt-4">
                <div class="member d-flex align-items-start">
                  <div class="pic"><img src="assets/img/doctors/doctors-3.jpg" class="img-fluid" alt=""></div>
                  <div class="member-info">
                    <h4>William Anderson</h4>
                    <span>Cardiology</span>
                    <p>Quisquam facilis cum velit laborum corrupti fuga rerum quia</p>
                    <div class="social">
                      <a href=""><i class="ri-twitter-fill"></i></a>
                      <a href=""><i class="ri-facebook-fill"></i></a>
                      <a href=""><i class="ri-instagram-fill"></i></a>
                      <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-6 mt-4">
                <div class="member d-flex align-items-start">
                  <div class="pic"><img src="assets/img/doctors/doctors-4.jpg" class="img-fluid" alt=""></div>
                  <div class="member-info">
                    <h4>Amanda Jepson</h4>
                    <span>Neurosurgeon</span>
                    <p>Dolorum tempora officiis odit laborum officiis et et accusamus</p>
                    <div class="social">
                      <a href=""><i class="ri-twitter-fill"></i></a>
                      <a href=""><i class="ri-facebook-fill"></i></a>
                      <a href=""><i class="ri-instagram-fill"></i></a>
                      <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                    </div>
                  </div>
                </div>
              </div>-->

            </div>

          </div>
        </section><!-- End Doctors Section -->

        <!-- ======= Frequently Asked Questions Section ======= -->
        <section id="faq" class="faq section-bg">
          <div class="container">

            <div class="section-title">
              <h2>Questions fréquemment posées</h2>
              <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
            </div>

            <div class="faq-list">
              <ul>
                <li data-aos="fade-up">
                  <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-1">Non consectetur a erat nam at lectus urna duis? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                  <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
                    <p>
                      Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
                    </p>
                  </div>
                </li>

                <li data-aos="fade-up" data-aos-delay="100">
                  <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-2" class="collapsed">Feugiat scelerisque varius morbi enim nunc? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                  <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
                    <p>
                      Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
                    </p>
                  </div>
                </li>

                <li data-aos="fade-up" data-aos-delay="200">
                  <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-3" class="collapsed">Dolor sit amet consectetur adipiscing elit? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                  <div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
                    <p>
                      Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis
                    </p>
                  </div>
                </li>

                <li data-aos="fade-up" data-aos-delay="300">
                  <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-4" class="collapsed">Tempus quam pellentesque nec nam aliquam sem et tortor consequat? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                  <div id="faq-list-4" class="collapse" data-bs-parent=".faq-list">
                    <p>
                      Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in.
                    </p>
                  </div>
                </li>

                <li data-aos="fade-up" data-aos-delay="400">
                  <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-5" class="collapsed">Tortor vitae purus faucibus ornare. Varius vel pharetra vel turpis nunc eget lorem dolor? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                  <div id="faq-list-5" class="collapse" data-bs-parent=".faq-list">
                    <p>
                      Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies leo integer malesuada nunc vel. Tincidunt eget nullam non nisi est sit amet. Turpis nunc eget lorem dolor sed. Ut venenatis tellus in metus vulputate eu scelerisque.
                    </p>
                  </div>
                </li>

              </ul>
            </div>

          </div>
        </section><!-- End Frequently Asked Questions Section -->

        <!-- ======= Testimonials Section ======= -->
        <section id="testimonials" class="testimonials">
          <div class="container">

            <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100" style="z-index: 0;">
              <div class="swiper-wrapper">

                <div class="swiper-slide">
                  <div class="testimonial-wrap">
                    <div class="testimonial-item">
                      <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                      <h3>Saul Goodman</h3>
                      <h4>Ceo &amp; Founder</h4>
                      <p>
                        <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                        Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.
                        <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                      </p>
                    </div>
                  </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                  <div class="testimonial-wrap">
                    <div class="testimonial-item">
                      <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                      <h3>Sara Wilsson</h3>
                      <h4>Designer</h4>
                      <p>
                        <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                        Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
                        <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                      </p>
                    </div>
                  </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                  <div class="testimonial-wrap">
                    <div class="testimonial-item">
                      <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                      <h3>Jena Karlis</h3>
                      <h4>Store Owner</h4>
                      <p>
                        <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                        Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.
                        <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                      </p>
                    </div>
                  </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                  <div class="testimonial-wrap">
                    <div class="testimonial-item">
                      <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                      <h3>Matt Brandon</h3>
                      <h4>Freelancer</h4>
                      <p>
                        <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                        Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.
                        <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                      </p>
                    </div>
                  </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                  <div class="testimonial-wrap">
                    <div class="testimonial-item">
                      <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                      <h3>John Larson</h3>
                      <h4>Entrepreneur</h4>
                      <p>
                        <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                        Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.
                        <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                      </p>
                    </div>
                  </div>
                </div><!-- End testimonial item -->

              </div>
              <div class="swiper-pagination"></div>
            </div>

          </div>
        </section><!-- End Testimonials Section -->

        <!-- ======= Gallery Section ======= -->
        <section id="gallery" class="gallery">
          <div class="container">

            <div class="section-title">
              <h2>Gallerie</h2>
              <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
            </div>
          </div>

          <div class="container-fluid">
            <div class="row no-gutters">

              <div class="col-lg-3 col-md-4">
                <div class="gallery-item">
                  <a href="assets/img/gallery/gallery-1.jpg" class="galelry-lightbox">
                    <img src="assets/img/gallery/gallery-1.jpg" alt="" class="img-fluid">
                  </a>
                </div>
              </div>

              <div class="col-lg-3 col-md-4">
                <div class="gallery-item">
                  <a href="assets/img/gallery/gallery-2.jpg" class="galelry-lightbox">
                    <img src="assets/img/gallery/gallery-2.jpg" alt="" class="img-fluid">
                  </a>
                </div>
              </div>

              <div class="col-lg-3 col-md-4">
                <div class="gallery-item">
                  <a href="assets/img/gallery/gallery-3.jpg" class="galelry-lightbox">
                    <img src="assets/img/gallery/gallery-3.jpg" alt="" class="img-fluid">
                  </a>
                </div>
              </div>

              <div class="col-lg-3 col-md-4">
                <div class="gallery-item">
                  <a href="assets/img/gallery/gallery-4.jpg" class="galelry-lightbox">
                    <img src="assets/img/gallery/gallery-4.jpg" alt="" class="img-fluid">
                  </a>
                </div>
              </div>

              <div class="col-lg-3 col-md-4">
                <div class="gallery-item">
                  <a href="assets/img/gallery/gallery-5.jpg" class="galelry-lightbox">
                    <img src="assets/img/gallery/gallery-5.jpg" alt="" class="img-fluid">
                  </a>
                </div>
              </div>

              <div class="col-lg-3 col-md-4">
                <div class="gallery-item">
                  <a href="assets/img/gallery/gallery-6.jpg" class="galelry-lightbox">
                    <img src="assets/img/gallery/gallery-6.jpg" alt="" class="img-fluid">
                  </a>
                </div>
              </div>

              <div class="col-lg-3 col-md-4">
                <div class="gallery-item">
                  <a href="assets/img/gallery/gallery-7.jpg" class="galelry-lightbox">
                    <img src="assets/img/gallery/gallery-7.jpg" alt="" class="img-fluid">
                  </a>
                </div>
              </div>

              <div class="col-lg-3 col-md-4">
                <div class="gallery-item">
                  <a href="assets/img/gallery/gallery-8.jpg" class="galelry-lightbox">
                    <img src="assets/img/gallery/gallery-8.jpg" alt="" class="img-fluid">
                  </a>
                </div>
              </div>

            </div>

          </div>
        </section><!-- End Gallery Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
          <div class="container">

            <div class="section-title">
              <h2>Contactez-nous</h2>
              <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
            </div>
          </div>

          <div>
            <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" allowfullscreen></iframe>
          </div>

          <div class="container">
            <div class="row mt-5">

              <div class="col-lg-4">
                <div class="info">
                  <div class="address">
                    <i class="bi bi-geo-alt"></i>
                    <h4>Location:</h4>
                    <p>rue commandant bjeoui , Sousse,Tunisie</p>
                  </div>

                  <div class="email">
                    <i class="bi bi-envelope"></i>
                    <h4>Email:</h4>
                    <p>info@example.com</p>
                  </div>

                  <div class="phone">
                    <i class="bi bi-phone"></i>
                    <h4>Télephone:</h4>
                    <p>+216 xxxxxxxx</p>
                  </div>

                </div>

              </div>

              <div class="col-lg-8 mt-5 mt-lg-0">

                <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <input type="text" name="name" class="form-control" id="name" placeholder="Votre Nom" required>
                    </div>
                    <div class="col-md-6 form-group mt-3 mt-md-0">
                      <input type="email" class="form-control" name="email" id="email" placeholder="Votre Email" required>
                    </div>
                  </div>
                  <div class="form-group mt-3">
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Sujet" required>
                  </div>
                  <div class="form-group mt-3">
                    <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                  </div>
                  <div class="my-3">
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your message has been sent. Thank you!</div>
                  </div>
                  <div class="text-center"><button type="submit">Envoyer le Message</button></div>
                </form>

              </div>

            </div>

          </div>
        </section><!-- End Contact Section -->

      </main><!-- End #main -->
    </div>
    <!-- ======= Footer ======= -->
    <footer id="footer">

      <div class="footer-top">
        <div class="container">
          <div class="row">

            <div class="col-lg-3 col-md-6 footer-contact">
              <h3>Clinique</h3>
              <p>
                Rue commandant bejaoui <br>
                Sousse,<br>
                Tunisie <br><br>
                <strong>Télephone:</strong> +216 xxxxxxxx<br>
                <strong>Email:</strong> info@example.com<br>
              </p>
            </div>

            <div class="col-lg-2 col-md-6 footer-links">
              <h4>Liens utils</h4>
              <ul>
                <li><i class="bx bx-chevron-right"></i> <a href="#">Accueil</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#">A propos</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#">Nos Services</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#">Conditions d'utilisation</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#">Politique de confidentialité</a></li>
              </ul>
            </div>

            <div class="col-lg-3 col-md-6 footer-links">
              <h4>Our Services</h4>
              <ul>
                <li><i class="bx bx-chevron-right"></i> <a href="#">Lorem epsim</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#">dolorem marquee</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#">d-md-inline</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#">dolorum</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#">badge</a></li>
              </ul>
            </div>

            <div class="col-lg-4 col-md-6 footer-newsletter">
              <h4>
                Rejoignez notre newsletter</h4>
              <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
              <form action="" method="post">
                <input type="email" name="email"><input type="submit" value="S'abonner">
              </form>
            </div>

          </div>
        </div>
      </div>

      <div class="container d-md-flex py-4">

        <div class="me-md-auto text-center text-md-start">
          <div class="copyright">
            &copy; Copyright <strong><span>Clinique</span></strong>. Tous les droits reservées
          </div>
          <div class="credits">

          </div>
        </div>
        <div class="social-links text-center text-md-right pt-3 pt-md-0">
          <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
          <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
          <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
          <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
          <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
        </div>
      </div>
    </footer><!-- End Footer -->



    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <!--<script src="assets/vendor/php-email-form/validate.js"></script>-->
    <script src="assets/vendor/purecounter/purecounter.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>


    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

  </body>

  </html>
<?php } else {
  header("Location:./accueil");
} ?>