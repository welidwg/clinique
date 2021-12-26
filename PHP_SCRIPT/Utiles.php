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

function GetNameByID($id)
{
    $conn = connect_bdd();
    $user = mysqli_fetch_array(mysqli_query($conn, "SELECT * from users where userID like $id"));
    return $user["Nom"];
}
function getuserdata($id)
{
    $connect = connect_bdd();

    return mysqli_fetch_array(mysqli_query($connect, "SELECT * from users where userID like $id"));
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

function getDeptName($id)
{
    $connect = connect_bdd();
    $dept = mysqli_fetch_array(mysqli_query($connect, "SELECT * from departement where id_dep=$id"));
    return $dept["nom_dep"];
}
function StatusColor($status)
{
    switch ($status) {
        case "confirme":
            return "green";
        case "en attente":
            return "orange";
        case "termine":
            return "darkgrey";
        case "depasse":
            return "red";
    }
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
function generateRandomString($length = 5)
{
    $characters = '0123456789abcdefghijklmnopqrs092u3tuvwxyzaskdhfhf9882323ABCDEFGHIJKLMNksadf9044OPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function sendMail($email, $subject, $body)
{
    include("../Mailer/src/PHPMailer.php");
    include("../Mailer/src/SMTP.php");
    require("../Mailer/src/Exception.php");


    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP(); // Paramétrer le Mailer pour utiliser SMTP 
    $mail->Host = 'smtp.gmail.com'; // Spécifier le serveur SMTP
    $mail->SMTPAuth = true; // Activer authentication SMTP
    $mail->SMTPSecure = 'ssl';
    $mail->Username = 'TechStoreManager@gmail.com';
    $mail->Password = 'Barcelona1899';
    $mail->Port = 465;
    $mail->SetFrom("test@gmail.com", "Clinique");
    $mail->AddAddress($email);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AltBody = $body;

    $mail->send();
}

function Insert_User($username, $name, $pass, $date, $mail, $role, $avatar, $dept)
{
    $conn = connect_bdd();
    $hash = md5($pass);
    if ($avatar == NULL) {
        $pic = "assets/images/avatar.png";
    } else {
        $pic = $avatar;
    }
    $test_name = mysqli_fetch_array(mysqli_query($conn, "SELECT * from users where NomUtilisateur like '$username'"));
    $test_mail = mysqli_fetch_array(mysqli_query($conn, "SELECT * from users where Email like '$mail'"));
    if (!empty($test_name) || !empty($test_mail)) {
        return false;
    } else {


        if (!mysqli_query($conn, "INSERT INTO users (NomUtilisateur,Nom,MotDePasse,DateDeNaissance,Email,Role,Avatar,id_dep) values('$username','$name','$hash','$date','$mail','$role','$pic',$dept)")) {
            echo mysqli_error($conn);
        } else {
            return true;
        }
    }
}

function Login_verif($email, $pass)
{
    $conn = connect_bdd();
    $pass_h = md5($pass);
    $sql = mysqli_fetch_array(mysqli_query($conn, "SELECT * from users where Email like '$email' and MotDePasse like '$pass_h' "));
    if (!empty($sql)) {
        return 1;
    } else {
        return 0;
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
            return "Pharmacien";
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
