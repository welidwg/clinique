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
    $_SESSION['LAST_ACTIVITY'] = time();
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

        setInterval(() => {
          Session();
        }, 500);

        function Session() {
          $.ajax({
            type: "post",
            url: "./PHP_SCRIPT/middleware.php",
            data: {
              query: "session"
            },
            success: function(data) {
              if (data == 1) {
                window.location.href = "?SessionExp"
              }

            }
          })
        }
        if (location.search == "?SessionExp") {
          alertify.alert("Information", "Votre session est expirée");
        }


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
              <li><a class="nav-link scrollto" href="#contact">Nos contacts</a></li>
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
                    La clinique offre une gamme complète et très différencie de service au plus haut niveau médical et thérapeuthique.
                    Nos principaux dommaines sont : en médecine générale , en churigie , immunologie , cardiologie , neurologie et radiologie.
                    Notre personel prend en charge et traite environ 1200 patients par un ans.
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
                        <h4>Transparence</h4>
                        <p>Le patient est placé au centre du dispositive manageriale dont le but est de lui offrir a la fois des conditions d'accées idéale , efficace et sécurisée. Ainsi que des confitions de séjours confortables et agréables.</p>
                      </div>
                    </div>
                    <div class="col-xl-4 d-flex align-items-stretch">
                      <div class="icon-box mt-4 mt-xl-0">
                        <i class="bx bx-cube-alt"></i>
                        <h4>Intégrité</h4>
                        <p>Conscient que la rapidité d'un patient peut lui sauver la vie, le personnel médical de la clinique
                          met tout en oeuvre pour accueillir le patient dans les meuilleurs conditions et lui accorder les traitements
                          dont il a besoin dans les plus brefs délais.
                        </p>
                      </div>
                    </div>
                    <div class="col-xl-4 d-flex align-items-stretch">
                      <div class="icon-box mt-4 mt-xl-0">
                        <i class="bx bx-images"></i>
                        <h4>L'excellenece </h4>
                        <p>Le clinique offre une pris en charge personnalisée,sécurisée globale et cordonnée.<br>en effet
                          pour mieux satisfaire ces patients,la clinique accorde égallement,une importance particuliere a la pris-en-charge de la douleur et au soins palliatifs.</p>
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
                <p>La clinique est une institution de santé multidisplinaire en Tunisie.Spécialisée en midicine générale , en chirigie,
                  immunologie , cardiologie , neurologie et radiologie.</p>

                <div class="icon-box">
                  <div class="icon"><i class="bx bx-fingerprint"></i></div>
                  <h4 class="title"><a href="">Nos Equipes</a></h4>
                  <p class="description">Nos équipes sont qualifiés et gradués parmis les meilleurs facultés du monde</p>
                </div>

                <div class="icon-box">
                  <div class="icon"><i class="bx bx-gift"></i></div>
                  <h4 class="title"><a href="">Nos offre</a></h4>
                  <p class="description">Notre clinique fournit à ces patients des offres et des promotions qui ne fronte pas des concurrances</p>
                </div>

                <div class="icon-box">
                  <div class="icon"><i class="bx bx-atom"></i></div>
                  <h4 class="title"><a href="">Nos Matériels</a></h4>
                  <p class="description">On a des matériels trop modernes qui necessite des formations spéciales pour nos equipes</p>
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
                  <?php
                  $num_doc = mysqli_num_rows(mysqli_query($connect, "SELECT * from users where role=3"));
                  $num_pat = mysqli_num_rows(mysqli_query($connect, "SELECT * from users where role=2"));
                  $num_stuff = mysqli_num_rows(mysqli_query($connect, "SELECT * from users where role=4 or role=1"));
                  $num_dept = mysqli_num_rows(mysqli_query($connect, "SELECT * from departement"));
                  ?>
                  <span data-purecounter-start="0" data-purecounter-end="<?php echo $num_doc ?>" data-purecounter-duration="1" class="purecounter"></span>
                  <p>Docteurs</p>
                </div>
              </div>

              <div class="col-lg-3 col-md-6 mt-5 mt-md-0">
                <div class="count-box">
                  <i class="far fa-hospital"></i>
                  <span data-purecounter-start="0" data-purecounter-end="<?php echo $num_dept ?>" data-purecounter-duration="1" class="purecounter"></span>
                  <p>Departements</p>
                </div>
              </div>
              <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                <div class="count-box">
                  <i class="fas fa-users"></i>
                  <span data-purecounter-start="0" data-purecounter-end="<?php echo $num_pat ?>" data-purecounter-duration="1" class="purecounter"></span>
                  <p>Patients</p>
                </div>
              </div>



              <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                <div class="count-box">
                  <i class="fas fa-user-nurse"></i>
                  <span data-purecounter-start="0" data-purecounter-end="<?php echo $num_stuff ?>" data-purecounter-duration="1" class="purecounter"></span>
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
              <p></p>
            </div>

            <div class="row">
              <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                <div class="icon-box">
                  <div class="icon"><i class="fas fa-heartbeat"></i></div>
                  <h4><a href="">Depatements diversifiés</a></h4>
                  <p>Nous avons un fort nombre des départements</p>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                <div class="icon-box">
                  <div class="icon"><i class="fas fa-pills"></i></div>
                  <h4><a href="">Pharmacie</a></h4>
                  <p>On dispose une pharmacie où on stock des divers médicaments</p>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
                <div class="icon-box">
                  <div class="icon"><i class="fas fa-hospital-user"></i></div>
                  <h4><a href="">Docteurs Experts</a></h4>
                  <p>Nos docteurs sont parmis les meilleurs dans le pays</p>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                <div class="icon-box">
                  <div class="icon"><i class="fas fa-dna"></i></div>
                  <h4><a href="">Temps</a></h4>
                  <p>Notre ponctualité fait tous nos patients satisfaits</p>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                <div class="icon-box">
                  <div class="icon"><i class="fas fa-wheelchair"></i></div>
                  <h4><a href="">Handicape</a></h4>
                  <p>Notre architecture prend en considération les handicaps</p>
                </div>
              </div>

              <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                <div class="icon-box">
                  <div class="icon"><i class="fas fa-notes-medical"></i></div>
                  <h4><a href="">Soins</a></h4>
                  <p>La majorité des nos médecins sont gradués de croissant rouge</p>
                </div>
              </div>

            </div>

          </div>
        </section>
        <!-- End Services Section -->

        <div id="Auth" class="modal">

          <!-- Modal content -->
          <div class="modal-content1">
            <div class="mainM" style="zoom: 0.9;">
              <span onclick="closeForm()" class="close">x</span>
              <form id="inscription" enctype="multipart/form-data" method="POST">
                <h1>Crée un compte</h1><br>
                <label for=""> Nom d'utilisateur</label>
                <input minlength="5" type="text" id="username1" name="nomUtilisateur" placeholder="Nom d'utilisateur" required="">
                <label for=""> Nom et prénom</label>
                <input minlength="6" type="text" name="nom" placeholder="Votre Nom" required="">
                <label for=""> Date de naissance</label>
                <input max="1999-12-31" type="date" name="datenaissance" placeholder="Date De naissance" required="">
                <label for=""> Email</label>
                <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" type="email" name="email" placeholder="Email" required="" id="emailI">
                <label for=""> Photo de profile </label>
                <input class="form-control" type="file" name="AVATAR" value="" accept="image/*">
                <label for=""> Mot de passe</label>
                <input id="mdp" minlength="5" type="password" name="motdepasse" placeholder="Mot de passe" required="">
                <label for=""> Confirmer mot de passe</label>
                <input id="confirmation" type="password" name="motdepasse" placeholder="Confirmer mot de passe" required="">

                <input type="hidden" name="sign">
                <button id="sub" name="SignUp">S'inscrire</button>
              </form>
              <script>
                jQuery(function($) {
                  $('#confirmation').on("keyup", function() {
                    if ($(this).val() !== $("#mdp").val()) {
                      $('#sub').attr("disabled", true);
                      $(this).css("border", "2px solid red");

                    } else {
                      $(this).css("border", "1px solid #ccc");
                      $('#sub').removeAttr("disabled");


                    }
                  })
                  $('#username1').on("keyup", function() {
                    $.ajax({
                      type: 'post',
                      url: './PHP_SCRIPT/Auth.php',
                      data: {
                        query: "username1",
                        data: $(this).val()
                      },
                      success: function(data) {

                        if (data == 1) {
                          $('#username1').css("border", "1px solid red")
                          alertify.error("Nom d'utilisateur déja existant");
                          $('#sub').attr("disabled", true);
                        } else {
                          $('#sub').removeAttr("disabled");
                          $('#username1').css("border", "1px solid #ccc")
                        }
                      },
                      error: function() {
                        alertify.error("error");
                      }
                    });
                  });
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
                          closeForm();
                        } else {
                          alertify.error(data)
                        }
                      },
                      error: function() {
                        alert("error");
                      }
                    });
                  });

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
                          $('#emailI').css("border", "1px solid red")
                          alertify.error("Email déja existant");
                          $('#sub').attr("disabled", true);
                        } else {
                          $('#sub').removeAttr("disabled");
                          $('#emailI').css("border", "1px solid #ccc")
                        }
                      },
                      error: function() {
                        alertify.error("error");
                      }
                    });
                  })
                })
              </script>

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
              <?php $doc = runQuery("SELECT * from users where Role=3 LIMIT 4");
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




        <!-- ======= Gallery Section ======= -->
        <section id="gallery" class="gallery">
          <div class="container">

            <div class="section-title">
              <h2>Gallerie</h2>
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
          </div>
          </div>

          <div>
            <iframe style="border:0; width: 50%; height: 350px;float: left;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3234.9269044312423!2d10.586686350437589!3d35.826269080063355!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12fd8b3a0237010f%3A0x4418fc1f1a3cb73f!2sPolytechnique%20Sousse!5e0!3m2!1sfr!2stn!4v1641181517634!5m2!1sfr!2stn" frameborder="0" allowfullscreen></iframe>
            <div class="container" style="width: 50%;">
              <div class="row mt-5">

                <div class="col-lg-8">
                  <div class="info">
                    <div class="address">
                      <i class="bi bi-geo-alt"></i>
                      <h4>Location:</h4>
                      <p>rue commandant bjeoui , Sousse,Tunisie</p>
                    </div>

                    <div class="email">
                      <i class="bi bi-envelope"></i>
                      <h4>Email:</h4>
                      <p>CliniqueManager@gmail.com</p>
                    </div>

                    <div class="phone">
                      <i class="bi bi-phone"></i>
                      <h4>Télephone:</h4>
                      <p>+216 55488241</p>
                    </div>

                  </div>

                </div>

              </div>
            </div><br>




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

            <div class="col-lg-3 col-md-6 footer-contact" style="margin-left: 240px;">
              <h3>Clinique</h3>
              <p>
                Rue commandant bejaoui <br>
                Sousse,<br>
                Tunisie <br><br>
                <strong>Télephone:</strong> +216 55488241<br>
                <strong>Email:</strong> CliniqueManager@gmail.com<br>
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
                <?php 
                $de=runQuery("SELECT * from departement ");
                foreach($de as $k=>$v){?>
                <li><i class="bx bx-chevron-right"></i> <a href="#"><?php echo $de[$k]['nom_dep'] ?></a></li>
                <?php } ?>
               
              </ul>
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