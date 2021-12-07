<?php
session_start();
if ($_SESSION["login"] == true) {
  $role = $_SESSION["role"];
  $username = $_SESSION["username"];
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <meta name="author" content="Clinique" />


    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link rel="shortcut icon" href="../assets/img/Clinique.png" />
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">



    <title>Dashboard</title>

    <link href="../assets/css/app.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet" />
  </head>
  <style>
    /* Subnav button */
    .dropdown-container {
      display: none;
      background-color: #262626;
      padding-left: 8px;



    }

    #submenu {
      position: relative;
      margin-left: 3.2em;
      display: none;
      transform: matrix3d(0.6);
      transition: .3s;
    }
  </style>

  <body>
    <div class="wrapper">
      <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
          <a class="sidebar-brand" href="#">
            <span class="align-middle">Clinique</span>
          </a>

          <ul class="sidebar-nav">
            <li class="sidebar-header">Outils</li>

            <li class="sidebar-item <?php if ($current == "accueil") {
                                      echo "active";
                                    } ?> ">
              <a class="sidebar-link" href="./accueil">
                <i class="align-middle" data-feather="sliders"></i>
                <span class="align-middle">Dashboard</span>
              </a>
            </li>
            <?php if ($role == 0) { ?>
              <li class="sidebar-item  <?php if ($current == "userList") {
                                          echo "active";
                                        } ?>">
                <a class="sidebar-link " href="<?php if ($current == "userList") {
                                                  echo "#";
                                                } else {
                                                  echo "./UserList";
                                                } ?>">
                  <i class="align-middle" data-feather="user"></i>
                  <span class="align-middle">Listes des utilisateurs</span>
                </a>


              </li>



              <li class="sidebar-item <?php if ($current == "adduser") {
                                        echo "active";
                                      } ?>">
                <a class="sidebar-link" href="./AddUser">
                  <i class="align-middle" data-feather="user-plus"></i>
                  <span class="align-middle">Ajouter un utilisateur</span>
                </a>
              </li>
            <?php } else if ($role == 1) {
            ?>
              <li class="sidebar-item " onclick="showStuff('submenu')">
                <span class="sidebar-link">
                  <i class="align-middle" data-feather="users"></i>
                  <span class="align-middle">Gestion des stuffs</span>

                </span>

                <div class="sidebar-item  submenu  <?php if ($current == "AddStuff") {
                                                      echo "active";
                                                    }  ?>" id="submenu" style=" display:<?php if ($current == "AddStuff") {
                                                                                          echo "block;";
                                                                                        } else {
                                                                                          echo "none,";
                                                                                        } ?>">
                  <a class="sidebar-link" href="./AddStuff">
                    <i class="align-middle" data-feather="plus"></i>
                    <span class="align-middle">Ajouter stuff</span>
                  </a>
                </div>


              </li>
              <li class="sidebar-item <?php if ($current == "userList") {
                                        echo "active";
                                      } ?>">
                <a class="sidebar-link" href="UserList">
                  <i class="align-middle" data-feather="book"></i>
                  <span class="align-middle">Liste des stuffs</span>
                </a>
              </li>

              <script>
                function showStuff(id) {
                  var x = document.getElementById(id);
                  if (x.style.display === "none") {
                    x.style.display = "block";
                  } else {
                    x.style.display = "none";
                  }

                }
              </script>

            <?php  } ?>
            <?php if ($role == 3) { ?>

              <li class="sidebar-item">
                <a class="sidebar-link" href="ListeRDV">
                  <i class="align-middle" data-feather="list"></i>
                  <span class="align-middle">Liste des rendez-vous</span>
                </a>
              </li>
            <?php } ?>




            <li class="sidebar-header">Tools & Components</li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="ui-buttons.html">
                <i class="align-middle" data-feather="square"></i>
                <span class="align-middle">Buttons</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="ui-forms.html">
                <i class="align-middle" data-feather="check-square"></i>
                <span class="align-middle">Forms</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="ui-cards.html">
                <i class="align-middle" data-feather="grid"></i>
                <span class="align-middle">Cards</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="ui-typography.html">
                <i class="align-middle" data-feather="align-left"></i>
                <span class="align-middle">Typography</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="icons-feather.html">
                <i class="align-middle" data-feather="coffee"></i>
                <span class="align-middle">Icons</span>
              </a>
            </li>

            <li class="sidebar-header">Plugins & Addons</li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="charts-chartjs.html">
                <i class="align-middle" data-feather="bar-chart-2"></i>
                <span class="align-middle">Charts</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="maps-google.html">
                <i class="align-middle" data-feather="map"></i>
                <span class="align-middle">Maps</span>
              </a>
            </li>
          </ul>


        </div>
      </nav>

      <div class="main">
        <nav class="navbar navbar-expand navbar-light navbar-bg">
          <a class="sidebar-toggle js-sidebar-toggle">
            <i class="hamburger align-self-center"></i>
          </a>

          <div class="navbar-collapse collapse">
            <ul class="navbar-nav navbar-align">

              <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                  <div class="position-relative">
                    <i class="align-middle" data-feather="bell"></i>
                    <span class="indicator">4</span>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                  <div class="dropdown-menu-header">4 New Notifications</div>
                  <div class="list-group">
                    <a href="#" class="list-group-item">
                      <div class="row g-0 align-items-center">
                        <div class="col-2">
                          <i class="text-danger" data-feather="alert-circle"></i>
                        </div>
                        <div class="col-10">
                          <div class="text-dark">Update completed</div>
                          <div class="text-muted small mt-1">
                            Restart server 12 to complete the update.
                          </div>
                          <div class="text-muted small mt-1">30m ago</div>
                        </div>
                      </div>
                    </a>
                    <a href="#" class="list-group-item">
                      <div class="row g-0 align-items-center">
                        <div class="col-2">
                          <i class="text-warning" data-feather="bell"></i>
                        </div>
                        <div class="col-10">
                          <div class="text-dark">Lorem ipsum</div>
                          <div class="text-muted small mt-1">
                            Aliquam ex eros, imperdiet vulputate hendrerit et.
                          </div>
                          <div class="text-muted small mt-1">2h ago</div>
                        </div>
                      </div>
                    </a>
                    <a href="#" class="list-group-item">
                      <div class="row g-0 align-items-center">
                        <div class="col-2">
                          <i class="text-primary" data-feather="home"></i>
                        </div>
                        <div class="col-10">
                          <div class="text-dark">Login from 192.186.1.8</div>
                          <div class="text-muted small mt-1">5h ago</div>
                        </div>
                      </div>
                    </a>
                    <a href="#" class="list-group-item">
                      <div class="row g-0 align-items-center">
                        <div class="col-2">
                          <i class="text-success" data-feather="user-plus"></i>
                        </div>
                        <div class="col-10">
                          <div class="text-dark">New connection</div>
                          <div class="text-muted small mt-1">
                            Christina accepted your request.
                          </div>
                          <div class="text-muted small mt-1">14h ago</div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="dropdown-menu-footer">
                    <a href="#" class="text-muted">Show all notifications</a>
                  </div>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
                  <div class="position-relative">
                    <i class="align-middle" data-feather="message-square"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="messagesDropdown">
                  <div class="dropdown-menu-header">
                    <div class="position-relative">4 New Messages</div>
                  </div>
                  <div class="list-group">
                    <a href="#" class="list-group-item">
                      <div class="row g-0 align-items-center">
                        <div class="col-2">
                          <img src="img/avatars/avatar-5.jpg" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker" />
                        </div>
                        <div class="col-10 ps-2">
                          <div class="text-dark">Vanessa Tucker</div>
                          <div class="text-muted small mt-1">
                            Nam pretium turpis et arcu. Duis arcu tortor.
                          </div>
                          <div class="text-muted small mt-1">15m ago</div>
                        </div>
                      </div>
                    </a>
                    <a href="#" class="list-group-item">
                      <div class="row g-0 align-items-center">
                        <div class="col-2">
                          <img src="img/avatars/avatar-2.jpg" class="avatar img-fluid rounded-circle" alt="William Harris" />
                        </div>
                        <div class="col-10 ps-2">
                          <div class="text-dark">William Harris</div>
                          <div class="text-muted small mt-1">
                            Curabitur ligula sapien euismod vitae.
                          </div>
                          <div class="text-muted small mt-1">2h ago</div>
                        </div>
                      </div>
                    </a>
                    <a href="#" class="list-group-item">
                      <div class="row g-0 align-items-center">
                        <div class="col-2">
                          <img src="img/avatars/avatar-4.jpg" class="avatar img-fluid rounded-circle" alt="Christina Mason" />
                        </div>
                        <div class="col-10 ps-2">
                          <div class="text-dark">Christina Mason</div>
                          <div class="text-muted small mt-1">
                            Pellentesque auctor neque nec urna.
                          </div>
                          <div class="text-muted small mt-1">4h ago</div>
                        </div>
                      </div>
                    </a>
                    <a href="#" class="list-group-item">
                      <div class="row g-0 align-items-center">
                        <div class="col-2">
                          <img src="img/avatars/avatar-3.jpg" class="avatar img-fluid rounded-circle" alt="Sharon Lessman" />
                        </div>
                        <div class="col-10 ps-2">
                          <div class="text-dark">Sharon Lessman</div>
                          <div class="text-muted small mt-1">
                            Aenean tellus metus, bibendum sed, posuere ac,
                            mattis non.
                          </div>
                          <div class="text-muted small mt-1">5h ago</div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <div class="dropdown-menu-footer">
                    <a href="#" class="text-muted">Show all messages</a>
                  </div>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                  <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                  <img src="../assets/img/avatars/0.png" class="avatar img-fluid rounded me-1" alt="Charles Hall" />
                  <span class="text-dark"><?php echo $username; ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                  <a class="dropdown-item" href="./Profile"><i class="align-middle me-1" data-feather="user"></i>
                    Profile</a>
                  <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i>
                    Analytics</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i>
                    Settings & Privacy</a>
                  <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i>
                    Help Center</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="../PHP_SCRIPT/Utiles.php?Logout">Déconnecter</a>
                </div>
              </li>
            </ul>
          </div>
        </nav>

        <main class="content">
          <div class="container-fluid p-0">


            <script src="../assets/js/app.js"></script>
            <script>
              document.addEventListener("DOMContentLoaded", function() {
                var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
                var gradient = ctx.createLinearGradient(0, 0, 0, 225);
                gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
                gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
                // Line chart
                new Chart(document.getElementById("chartjs-dashboard-line"), {
                  type: "line",
                  data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                      label: "Sales ($)",
                      fill: true,
                      backgroundColor: gradient,
                      borderColor: window.theme.primary,
                      data: [
                        2115,
                        1562,
                        1584,
                        1892,
                        1587,
                        1923,
                        2566,
                        2448,
                        2805,
                        3438,
                        2917,
                        3327
                      ]
                    }]
                  },
                  options: {
                    maintainAspectRatio: false,
                    legend: {
                      display: false
                    },
                    tooltips: {
                      intersect: false
                    },
                    hover: {
                      intersect: true
                    },
                    plugins: {
                      filler: {
                        propagate: false
                      }
                    },
                    scales: {
                      xAxes: [{
                        reverse: true,
                        gridLines: {
                          color: "rgba(0,0,0,0.0)"
                        }
                      }],
                      yAxes: [{
                        ticks: {
                          stepSize: 1000
                        },
                        display: true,
                        borderDash: [3, 3],
                        gridLines: {
                          color: "rgba(0,0,0,0.0)"
                        }
                      }]
                    }
                  }
                });
              });
            </script>
            <script>
              document.addEventListener("DOMContentLoaded", function() {
                // Pie chart
                new Chart(document.getElementById("chartjs-dashboard-pie"), {
                  type: "pie",
                  data: {
                    labels: ["Chrome", "Firefox", "IE"],
                    datasets: [{
                      data: [4306, 3801, 1689],
                      backgroundColor: [
                        window.theme.primary,
                        window.theme.warning,
                        window.theme.danger
                      ],
                      borderWidth: 5
                    }]
                  },
                  options: {
                    responsive: !window.MSInputMethodContext,
                    maintainAspectRatio: false,
                    legend: {
                      display: false
                    },
                    cutoutPercentage: 75
                  }
                });
              });
            </script>
            <script>
              document.addEventListener("DOMContentLoaded", function() {
                // Bar chart
                new Chart(document.getElementById("chartjs-dashboard-bar"), {
                  type: "bar",
                  data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                      label: "This year",
                      backgroundColor: window.theme.primary,
                      borderColor: window.theme.primary,
                      hoverBackgroundColor: window.theme.primary,
                      hoverBorderColor: window.theme.primary,
                      data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
                      barPercentage: .75,
                      categoryPercentage: .5
                    }]
                  },
                  options: {
                    maintainAspectRatio: false,
                    legend: {
                      display: false
                    },
                    scales: {
                      yAxes: [{
                        gridLines: {
                          display: false
                        },
                        stacked: false,
                        ticks: {
                          stepSize: 20
                        }
                      }],
                      xAxes: [{
                        stacked: false,
                        gridLines: {
                          color: "transparent"
                        }
                      }]
                    }
                  }
                });
              });
            </script>
            <script>
              document.addEventListener("DOMContentLoaded", function() {
                var markers = [{
                    coords: [31.230391, 121.473701],
                    name: "Shanghai"
                  },
                  {
                    coords: [28.704060, 77.102493],
                    name: "Delhi"
                  },
                  {
                    coords: [6.524379, 3.379206],
                    name: "Lagos"
                  },
                  {
                    coords: [35.689487, 139.691711],
                    name: "Tokyo"
                  },
                  {
                    coords: [23.129110, 113.264381],
                    name: "Guangzhou"
                  },
                  {
                    coords: [40.7127837, -74.0059413],
                    name: "New York"
                  },
                  {
                    coords: [34.052235, -118.243683],
                    name: "Los Angeles"
                  },
                  {
                    coords: [41.878113, -87.629799],
                    name: "Chicago"
                  },
                  {
                    coords: [51.507351, -0.127758],
                    name: "London"
                  },
                  {
                    coords: [40.416775, -3.703790],
                    name: "Madrid "
                  }
                ];
                var map = new jsVectorMap({
                  map: "world",
                  selector: "#world_map",
                  zoomButtons: true,
                  markers: markers,
                  markerStyle: {
                    initial: {
                      r: 9,
                      strokeWidth: 7,
                      stokeOpacity: .4,
                      fill: window.theme.primary
                    },
                    hover: {
                      fill: window.theme.primary,
                      stroke: window.theme.primary
                    }
                  },
                  zoomOnScroll: false
                });
                window.addEventListener("resize", () => {
                  map.updateSize();
                });
              });
            </script>
            <script>
              document.addEventListener("DOMContentLoaded", function() {
                var date = new Date(Date.now() - 5 * 24 * 60 * 60 * 1000);
                var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();
                document.getElementById("datetimepicker-dashboard").flatpickr({
                  inline: true,
                  prevArrow: "<span title=\"Previous month\">&laquo;</span>",
                  nextArrow: "<span title=\"Next month\">&raquo;</span>",
                  defaultDate: defaultDate
                });
              });
            </script>
  </body>
  <script src="../assets/js/jQuery.js"></script>

  </html>

<?php } else {
  header("Location:/../clinique/index");
} ?>