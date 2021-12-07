<?php
require("Utiles.php");

connect_bdd();

if (isset($_POST["SignUp"])){

    $name=$_POST["nom"];
    $pass=$_POST["motdepasse"];
    $mail=$_POST["email"];
    $username=$_POST["nomUtilisateur"];
    $date=$_POST["datenaissance"];
    Insert_User($username,$name,$pass,$date,$mail,2,NULL);

}else if(isset($_POST["Login"])){

    $username=$_POST["NomUtilisateur"];
    $pswd=$_POST["pswd"];
    
   $verif= Login_verif($username,$pswd);
    if($verif==1){
        session_start();
        $conn=connect_bdd();
        $user=mysqli_fetch_array(mysqli_query($conn,"SELECT * from users where Nomutilisateur like '$username'"));
        $_SESSION["login"]=true;
        $_SESSION["username"]=$username;
        $_SESSION["nom"]=$user["Nom"];
        $_SESSION["role"]=$user["Role"];
        $_SESSION["email"]=$user["Email"];
        if($user["Role"]==2){
           header("Location:../index");

        }else{
           header("Location:../dashboard/accueil");
        }

        

    }elseif($verif==11){
        echo "utilsiateur non trouvée";

    }else{
        echo "mot de passe incorrecte";
    }
    
}

?>