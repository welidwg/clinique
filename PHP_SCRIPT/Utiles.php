<?php
function connect_bdd()
{
    $conn = mysqli_connect("localhost", "root", "") or die("Erreur de conenxion");
    mysqli_select_db($conn, "clinique");
    return $conn;
}
$connect = connect_bdd();

function GetNom()
{
    return $_SESSION["nom"];
}
function GetEmail()
{
    return $_SESSION["email"];
}

function GetID()
{
    return $_SESSION["idUser"];
}

function GetUsername()
{
    return $_SESSION["username"];
}
function runQuery($query)
{
    $connect = connect_bdd();

    $result = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $resultset[] = $row;
    }
    if (!empty($resultset))
        return $resultset;
}

function Insert_User($username, $name, $pass, $date, $mail, $role, $avatar, $dept)
{
    $conn = connect_bdd();
    $hash = md5($pass);
    $test_name = mysqli_fetch_array(mysqli_query($conn, "SELECT * from users where NomUtilisateur like '$username'"));
    $test_mail = mysqli_fetch_array(mysqli_query($conn, "SELECT * from users where Email like '$mail'"));
    if (!empty($test_name) || !empty($test_mail)) {
        return false;
    } else {

        if (!mysqli_query($conn, "INSERT INTO users (NomUtilisateur,Nom,MotDePasse,DateDeNaissance,Email,Role,Avatar,id_dep) values('$username','$name','$hash','$date','$mail','$role','$avatar','$dept')")) {
            echo mysqli_error($conn);
        } else {
            return true;
        }
    }
}

function Login_verif($username, $pass)
{
    $conn = connect_bdd();
    $pass_h = md5($pass);
    $sql = mysqli_fetch_array(mysqli_query($conn, "SELECT * from users where NomUtilisateur like '$username'"));
    if (!empty($sql)) {
        $sql2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * from users where MotDePasse like '$pass_h'"));
        if (!empty($sql2)) {
            return 1;
        } else {
            return 22;
        }
    } else {
        return 11;
    }
}

function Role($num)
{
    switch ($num) {
        case 0:
            return "Admin";
            break;
        case 1:
            return "Responsable Stuff";
            break;
        case 2:
            return "Patient";
            break;
        case 3:
            return "Docteur";
            break;
        case 4:
            return "Infirmier";
            break;
        default:
            return NULL;
    }
}

function verify_user($column, $value)
{
    $connect = connect_bdd();
    if (mysqli_num_rows(mysqli_query($connect, "SELECT * from users where $column like '$value' ")) == 0) {
        return true;
    } else {
        return false;
    }
}

function redirect($url)
{
    if (headers_sent()) {

        echo ("<meta http-equiv='refresh' content='0;  URL =" . $url . "'/>");
    } else {
        ob_start();
        header('Location: ' . $url);
        die();
    }
}

if (isset($_GET["Logout"])) {
    session_start();
    session_unset();
    session_destroy();
    header("Location:../index");
} else if (isset($_GET["query"])) {
    switch ($_GET["query"]) {
        case "AddUser_usrname":
            $mail = $_GET["username"];
            if (verify_user("NomUtilisateur", $mail)) {
                echo 1;
            } else {
                echo 0;
            }
            break;
        case "AddUser_mail":
            $mail = $_GET["mail"];
            if (verify_user("Email", $mail)) {
                echo 1;
            } else {
                echo 0;
            }
            break;
        case "doctors":
            $id_dep = $_GET["id_dept"];
            $array = runQuery("SELECT * from users where id_dep = $id_dep");
            if (!empty($array)) {
                $i = 1;
                foreach ($array as $k => $v) {

                    $data[] = array(
                        'nom' => $array[$k]["Nom"],
                        'id_doc' => $array[$k]["userID"]

                    );
                }
            } else {
                $data = 0;
            }
            echo json_encode($data);


            break;
    }
}
