<?php
function connect_bdd(){
    $conn = mysqli_connect("localhost","root","") or die("Erreur de conenxion");
    mysqli_select_db($conn,"clinique");
    return $conn;

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

function Insert_User($username,$name,$pass,$date,$mail,$role,$avatar){
   $conn= connect_bdd();
   $hash=md5($pass);
$test_name = mysqli_fetch_array(mysqli_query($conn, "SELECT * from users where NomUtilisateur like '$username'"));
$test_mail = mysqli_fetch_array(mysqli_query($conn, "SELECT * from users where Email like '$mail'"));
if(!empty($test_name) || !empty($test_mail)  ){
        header("Location:index?Exist");

}else{
    if(!mysqli_query($conn,"INSERT INTO users (NomUtilisateur,Nom,MotDePasse,DateDeNaissance,Email,Role,Avatar) values('$username','$name','$hash','$date','$mail','$role','$avatar')")){
        echo mysqli_error($conn);
    }else{
        header("Location:../index?Done");
    }
    
}

}

function Login_verif($username,$pass){
    $conn=connect_bdd();
    $pass_h=md5($pass);
    $sql=mysqli_fetch_array(mysqli_query($conn,"SELECT * from users where NomUtilisateur like '$username'"));
    if(!empty($sql)){
        $sql2=mysqli_fetch_array(mysqli_query($conn,"SELECT * from users where MotDePasse like '$pass_h'"));
        if(!empty($sql2)){
              return 1;
        }else{
            return 22;
        }
        

    }else{
        return 11;
    }

}

function Role($num){
    switch($num){
        case 0 : return "Admin"; break;
        case 1 : return "Responsable Stuff"; break;
        case 2 : return "Patient";break;
        default: return NULL;
    }

}

if(isset($_GET["Logout"])){
    session_start();
    session_unset();
    session_destroy();
    header("Location:../index");
}
?>