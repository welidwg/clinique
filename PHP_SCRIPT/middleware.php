      <?php

        require_once("./Utiles.php");
        session_start();
        $connect = connect_bdd();


        if (isset($_POST["formRes"])) {
            $id = $_SESSION["idUser"];
            $nom = $_SESSION["nom"];
            $email = $_SESSION["email"];
            $tel = $_POST["tel"];
            $date = $_POST["date"];
            $dept = $_POST["departement"];
            $doc = $_POST["doctor"];
            $message = $_POST["message"];
            $check = mysqli_num_rows(mysqli_query($connect, "SELECT * from rendez_vous where id_pat = $id and date_rdv like '$date' and id_docteur = $doc"));
            if ($check > 0) {
                echo 0;
            } else {
                $sql = "INSERT INTO `rendez_vous`(`id_pat`, `nom_pat`, `email_pat`, `tel_pat`, `date_rdv`, `id_dep`, `id_docteur`, `message`,status) values ($id,'$nom','$email',$tel,'$date',$dept,$doc,'$message','en attente')";
                if (mysqli_query($connect, $sql)) {
                    echo 1;
                    //redirect("index?Done&#appointment");
                } else {
                    echo mysqli_error($connect);
                }
            }
        } else if (isset($_POST["edit"])) {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $datenaiss = $_POST["datenaiss"];
            $mdp = $_POST["mdp"];
            $id = $_SESSION["idUser"];
            if ($_POST["tel"] != "") {
                $tel = $_POST["tel"];
                $_SESSION["tel"] = $tel;
            } else {
                $tel = "NULL";
                $_SESSION["tel"] = NULL;
            }
            if (isset($_FILES["avatar"]) && $_FILES["avatar"]["name"] != "") {
                $v1 = rand(1111, 9999);
                $v2 = rand(1111, 9999);
                $v3 = $v1 . $v2;
                $v3 = md5($v3);
                $Img = $_FILES["avatar"]["name"];
                $destination = "uploads/" . $v3 . $Img;
                $destination1 = "../uploads/" . $v3 . $Img;
                move_uploaded_file($_FILES["avatar"]["tmp_name"], $destination1);
                $_SESSION["avatar"] = $destination;
            } else {
                $destination = $_SESSION["avatar"];
            }
            if ($mdp != "") {
                $hash = md5($mdp);
                $sql = "UPDATE users SET Nom='$name',Email='$email',DateDeNaissance='$datenaiss',MotDePasse='$hash',tel=$tel, Avatar='$destination' where userID = $id";
            } else {
                $sql = "UPDATE users SET Nom='$name',Email='$email',DateDeNaissance='$datenaiss',tel=$tel ,Avatar='$destination' where userID = $id";
            }
            if (mysqli_query($connect, $sql)) {
                echo 1;
            } else {
                echo mysqli_error($connect);
            }
        } else if (isset($_POST["iduserEDIT"])) {
            /* fomulraire de modifier compte */
            // role : admin
            $id = $_POST["iduserEDIT"];
            $nom = $_POST["nom"];
            $email = $_POST["email"];
            $date = $_POST["datenaiss"];
            $role = $_POST["role"];
            if ($role == 3) {
                $dept = $_POST["departement"];
            } else {
                $dept = 0;
            }
            if (mysqli_query($connect, "UPDATE users SET Nom='$nom',Email='$email',DateDeNaissance='$date',id_dep=$dept,Role=$role where userID=$id")) {
                echo 1;
            } else {
                echo mysqli_error($connect);
            }
        } else if (isset($_POST["idDeptEDIT"])) {
            $id = $_POST["idDeptEDIT"];
            //$check = mysqli_fetch_array(mysqli_query($connect, "SELECT * from departement where id_dep = $id"));
            // $avat = $check["image"];
            $nom = $_POST["nomdeptE"];
            $desc = mysqli_real_escape_string($connect, $_POST["descdept"]);
            if (isset($_FILES["pic"]["name"]) && $_FILES["pic"]["name"] != "") {
                $v1 = rand(1111, 9999);
                $v2 = rand(1111, 9999);
                $v3 = $v1 . $v2;
                $v3 = md5($v3);
                $Img = $_FILES["pic"]["name"];
                $destination = "../uploads/" . $v3 . $Img;
                $destination1 = "uploads/" . $v3 . $Img;
                move_uploaded_file($_FILES["pic"]["tmp_name"], $destination);
            } else {
                $destination1 = $_POST["deptpic"];
            }

            if (mysqli_query($connect, "UPDATE departement SET nom_dep='$nom',description='$desc',image='$destination1' where id_dep=$id")) {
                echo 1;
            } else {
                echo mysqli_error($connect);
            }
        } else if (isset($_POST["idMedEdit"])) {
            $nom = $_POST["nom"];
            $action = $_POST["action"];
            $origStock = $_POST["stockH"];
            $stock = $_POST["stock"];
            $id = $_POST["idMedEdit"];
            if ($action == 0) {
                $newStock = $origStock - $stock;
            } else if ($action == 1) {
                $newStock = $origStock + $stock;
            } else {
                $newStock = $origStock;
            }
            if (mysqli_query($connect, "UPDATE pharmacie set nom='$nom',stock='$newStock' where id=$id ")) {
                echo 1;
            } else {
                echo mysqli_error($connect);
            }
        }

        if (isset($_POST["query"])) {
            if ($_POST["query"] == "tel") {
                $tel = $_POST["data"];
                if ($tel != $_SESSION["tel"]) {
                    $num = mysqli_num_rows(mysqli_query($connect, "SELECT * from users where tel=$tel"));
                    if ($num > 0) {
                        echo 1;
                    } else {
                        echo 0;
                    }
                } else {
                    echo 0;
                }
            } else if ($_POST["query"] == "verifStatus") {
                $currentDate = date("Y-m-d");
                $currentTime = date("H:i:s", strtotime("1 hour"));
                $array = runQuery("SELECT * from rendez_vous where status like 'en attente' or status like 'confirme' ");
                if (!empty($array)) {
                    foreach ($array as $k => $v) {
                        $date = $array[$k]["date_rdv"];
                        $time = $array[$k]["temp_rdv"];
                        $id = $array[$k]["id_rend"];
                        $sql = "UPDATE rendez_vous SET status = 'depasse' where id_rend like $id";
                        if ($date < $currentDate) {
                            mysqli_query($connect, $sql);
                            echo "done";
                        } else if ($date == $currentDate) {
                            if ($currentTime > $time) {
                                mysqli_query($connect, $sql);
                                echo "done";
                            }
                        }
                    }
                }
            } else if ($_POST["query"] == "userDelete") {
                $id = $_POST["id"];
                if (mysqli_query($connect, "DELETE FROM users where userID =$id")) {
                    echo 1;
                } else {
                    echo mysqli_error($connect);
                }
            } else if ($_POST["query"] == "editUser") {
                $id = $_POST["id"];
                $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from users where userID like $id"));
                $id_dep = $user["id_dep"];
                if ($id_dep != 0) {

                    $dept = runQuery("SELECT * from departement where id_dep!=$id_dep");
                    $nomdept = mysqli_fetch_array(mysqli_query($connect, "SELECT * from departement where id_dep=$id_dep"));
                } else {
                    $dept =
                        runQuery("SELECT * from departement where id_dep!=$id_dep");
                    $nomdept = array("nom_dep" => "");
                }
                $arr = array(
                    "nom" => $user["Nom"], "datenaiss" => $user["DateDeNaissance"],
                    "email" => $user["Email"], "role" => $user["Role"], "id" => $user["userID"],
                    "role_name" => Role($user["Role"]), "dept" => $dept, "nom_dep" => $nomdept["nom_dep"], "id_dep" => $id_dep
                );

                echo json_encode($arr);
            } else if ($_POST["query"] == "deptDelete") {
                $id = $_POST["id"];
                if (mysqli_query($connect, "DELETE FROM departement where id_dep=$id")) {
                    echo 1;
                } else {
                    echo mysqli_error($connect);
                }
            } else if ($_POST["query"] == "editDept") {
                $id = $_POST["id"];
                $nom = mysqli_fetch_array(mysqli_query($connect, "SELECT * from departement where id_dep = $id"));
                $arr = array(
                    "nom" => $nom["nom_dep"], "id" => $nom["id_dep"], "desc" => $nom["description"],
                    "image" => $nom["image"]
                );
                echo json_encode($arr);
            } else if ($_POST["query"] == "deptnom") {
                $nom = $_POST["data"];
                $num = mysqli_num_rows(mysqli_query($connect, "SELECT * from departement where nom_dep like '$nom'"));
                echo $num;
            } else if ($_POST["query"] == "MedCode") {
                $code = $_POST["data"];
                $num = mysqli_num_rows(mysqli_query($connect, "SELECT * from pharmacie where code like '$code'"));
                echo $num;
            } else if ($_POST["query"] == "MedDelete") {
                $id = $_POST["id"];
                if (mysqli_query($connect, "DELETE FROM pharmacie where id=$id")) {
                    echo 1;
                } else {
                    echo mysqli_error($connect);
                }
            } else if ($_POST["query"] == "editMed") {
                $id = $_POST["id"];
                $nom = mysqli_fetch_array(mysqli_query($connect, "SELECT * from pharmacie where id = $id"));
                $arr = array(
                    "code" => $nom["code"], "id" => $nom["id"], "nom" => $nom["nom"],
                    "stock" => $nom["stock"]
                );
                echo json_encode($arr);
            } else if ($_POST["query"] == "session") {
                if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 800)) {
                    // last request was more than 30 minutes ago
                    session_unset();     // unset $_SESSION variable for the run-time 
                    session_destroy();   // destroy session data in storage
                    echo 1;
                }
            }
        }

        if (isset($_POST["id_rend"])) {
            $id = $_POST["id_rend"];
            if (mysqli_query($connect, "DELETE FROM rendez_vous where id_rend = $id")) {
                echo "Supression Reuissite";
            } else {
                echo "Erreur de serveur";
            }
        } else if (isset($_POST["id_rendC"])) {
            $id = $_POST["id_rendC"];
            $time = date("H:i:s", strtotime($_POST["time"]));
            $hour = date("H", strtotime($time));
            $mail = $_POST["mail"];
            $rdv = mysqli_fetch_array(mysqli_query($connect, "SELECT * from rendez_vous WHERE id_rend = '$id'"));

            $daterdv = $rdv["date_rdv"];
            $id_doc = $rdv["id_docteur"];
            $title = "Confirmation de rendez vous";
            $body = "Bonjour Monsieur/Madame <strong>" . $rdv["nom_pat"] . "</strong><br>
                Nous vous informons que votre rendez vous avec Le docteur <strong>" . GetNameByID($rdv["id_docteur"]) . "</strong> est fixé le 
                <p style='color:limegreen'>" . date("d-m-Y", strtotime($rdv["date_rdv"])) . " / " . date("H:i", strtotime($time)) . "</p><br>
                ";
            $verif_time = mysqli_num_rows(mysqli_query($connect, "SELECT * from rendez_vous where id_docteur=$id_doc and date_rdv like '$daterdv' and HOUR(TIMEDIFF(temp_rdv, '$time'))=0"));

            if ($verif_time > 0) {
                echo 2;
            } else {
                if (mysqli_query($connect, "UPDATE rendez_vous SET status='confirme',temp_rdv='$time' WHERE id_rend = $id")) {
                    sendMail($_POST["mail"], $title, $body);
                    echo 1;
                } else {
                    echo mysqli_error($connect);
                }
            }
        } else if (isset($_POST["id_rendEnd"])) {
            $id = $_POST["id_rendEnd"];
            if (mysqli_query($connect, "UPDATE rendez_vous SET status='termine' where id_rend = $id")) {
                echo 1;
            } else {
                echo mysqli_error($connect);
            }
        } else if (isset($_POST["idrendDEL"])) {
            $id = $_POST["idrendDEL"];
            if (mysqli_query($connect, "DELETE FROM rendez_vous where id_rend =$id")) {
                echo 1;
            } else {
                echo mysqli_error($connect);
            }
        } else if (isset($_POST["ajouterDept"])) {
            $nom = $_POST["nom"];
            $desc = $_POST["desc"];
            $v1 = rand(1111, 9999);
            $v2 = rand(1111, 9999);
            $v3 = $v1 . $v2;
            $v3 = md5($v3);
            $Img = $_FILES["pic"]["name"];
            $destination = "../uploads/" . $v3 . $Img;
            $destination1 = "uploads/" . $v3 . $Img;
            move_uploaded_file($_FILES["pic"]["tmp_name"], $destination);
            if (mysqli_query($connect, "INSERT INTO  departement (nom_dep,description,image) values('$nom','$desc','$destination1')")) {
                echo 1;
            } else {
                echo mysqli_error($connect);
            }
        } else if (isset($_POST["ajouterMed"])) {
            $code = $_POST["code"];
            $nom = $_POST["nom"];
            $stock = $_POST["stock"];
            if (mysqli_query($connect, "INSERT INTO pharmacie (code,nom,stock) value('$code','$nom',$stock)")) {
                echo 1;
            } else {
                echo mysqli_error($connect);
            }
        }



        ?>