<?php
require("Utiles.php");
session_start();
$connect = connect_bdd();

if (isset($_POST["sign"])) {
    $name = $_POST["nom"];
    $pass = $_POST["motdepasse"];
    $mail = $_POST["email"];
    $username = $_POST["nomUtilisateur"];
    $date = $_POST["datenaissance"];
    $v1 = rand(1111, 9999);
    $v2 = rand(1111, 9999);
    $v3 = $v1 . $v2;
    $v3 = md5($v3);
    if (isset($_FILES["AVATAR"]) && $_FILES["AVATAR"]["name"] != "") {
        $Img = $_FILES["AVATAR"]["name"];
        $destination = "../uploads/" . $v3 . $Img;
        $destination1 = "uploads/" . $v3 . $Img;
        move_uploaded_file($_FILES["AVATAR"]["tmp_name"], $destination);
    } else {
        $destination1 = "assets/images/avatar.png";
    }

    if (Insert_User($username, $name, $pass, $date, $mail, 2, $destination1, 0)) {
        echo "1";
    } else {
        echo mysqli_error($connect);
    }
} else if (isset($_POST["LogForm"])) {

    $email = $_POST["email"];
    $pswd = $_POST["pswd"];

    $verif = Login_verif($email, $pswd);
    if ($verif == 1) {
        session_start();
        $conn = connect_bdd();
        $user = mysqli_fetch_array(mysqli_query($conn, "SELECT * from users where Email like '$email'"));
        $_SESSION["login"] = true;
        $_SESSION["username"] = $user["NomUtilisateur"];
        $_SESSION["nom"] = $user["Nom"];
        $_SESSION["role"] = $user["Role"];
        $_SESSION["datenaiss"] = $user["DateDeNaissance"];
        $_SESSION["email"] = $email;
        $_SESSION["idUser"] = $user["userID"];
        $_SESSION["avatar"] = $user["Avatar"];
        $_SESSION["tel"] = $user["tel"];

        echo "ok";
    } elseif ($verif == 0) {
        // redirect("../index?notfound");
        echo "notfound";
    }
}

if (isset($_POST["addStuff"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $name = $_POST['nom'];
    $date = $_POST["date"];
    $role = $_POST["role"];
    if (isset($_POST["dept"]) && $_POST["dept"]  != "") {
        $dept = $_POST["dept"];
    } else {
        $dept = 0;
    }
    $mdp = md5($_POST["pswd"]);
    if (!Insert_User($username, $name, $mdp, $date, $email, $role, NULL, $dept)) {
        echo mysqli_error($connect);
    } else {
        echo  1;
    }
}

if (isset($_POST["query"])) {
    if ($_POST["query"] == "username") {
        $usr = $_POST["data"];
        $num = mysqli_num_rows(mysqli_query($connect, "SELECT * from users where NomUtilisateur like '$usr' "));
        echo $num;
    } else if ($_POST["query"] == "email") {
        $email = $_POST["data"];
        $num = mysqli_num_rows(mysqli_query($connect, "SELECT * from users where Email like '$email' "));
        echo $num;
    } else if ($_POST["query"] == "emailProfile") {
        $email = $_POST["data"];
        $iduser = $_SESSION["idUser"];
        $oldmail = mysqli_fetch_array(mysqli_query($connect, "SELECT * from users where userID=$iduser"));
        if ($email == $oldmail["Email"]) {
            echo 0;
        } else {
            $num = mysqli_num_rows(mysqli_query($connect, "SELECT * from users where Email like '$email' "));
            echo $num;
        }
    } else if ($_POST["query"] == "emailModif") {
        $email = $_POST["email"];
        $iduser = $_POST["idUser"];
        $oldmail = mysqli_fetch_array(mysqli_query($connect, "SELECT * from users where userID=$iduser"));
        if ($email == $oldmail["Email"]) {
            echo 0;
        } else {
            $num = mysqli_num_rows(mysqli_query($connect, "SELECT * from users where Email like '$email' "));
            echo $num;
        }
    } else if ($_POST["query"] == "refresh_Session") {
        $id = $_POST["id"];
        $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from users where userID=$id"));
        if (isset($_SESSION["login"])) {


            $_SESSION["nom"] = $user["Nom"];
            $_SESSION["datenaiss"] = $user["DateDeNaissance"];
            $_SESSION["email"] = $user["Email"];
            $_SESSION["avatar"] = $user["Avatar"];
            $_SESSION["tel"] = $user["tel"];
            $arr = array(
                "nom" => $_SESSION["nom"], "email" => $_SESSION["email"], "datenaiss" => $_SESSION["datenaiss"],
                "tel" => $_SESSION["tel"], "avatar" => $_SESSION["avatar"]
            );
            echo json_encode($arr);
        }
    } else if ($_POST["query"] == "Forget") {
        $email = $_POST["email"];
        $user = mysqli_fetch_array(mysqli_query($connect, "SELECT * from users where Email like '$email'"));
        $code = generateRandomString();
        $nom = $user["Nom"];
        $subjet = mysqli_real_escape_string($connect, "Recuperation de mot de passe");
        $body = "Salut Mr/Madame <strong> " . $nom . "</strong><br>
       Votre code de confirmation c'est : <strong>" . $code . "</strong>";
        sendMail($email, $subjet, $body);
        echo $code;
    } else if ($_POST["query"] == "ChangePass") {
        $email = $_POST["email"];
        $mdp = md5($_POST["data"]);
        if (mysqli_query($connect, "UPDATE users SET MotDePasse='$mdp' where Email like '$email'")) {
            echo 1;
        } else {
            echo mysqli_error($connect);
        }
    }
}
