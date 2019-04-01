<?php

require_once "GlobalFunctions.php";


if(isset($_GET['func'])) {
    if(isset($_GET['id'])){
        $_GET['func']($_GET['id']);
    }
    else {
        //echo "Yes! C'est bon! <br>";
        $_GET['func']();
    }
}

function login(){
    $connection = connectDB();

    //Makes sure the login and the password fields are not empty
    if (empty($_POST['login']) || empty($_POST['password'])) {
        redirect("../View/Admin/Login.php?error=bad_login");
    }
    $login=$_POST['login'];
    $dbLogin = $connection->prepare("SELECT username FROM Admin");
    $dbLogin->execute();
    $dbLogin = $dbLogin->fetchAll();

    $dbPassword = NULL;
    foreach ($dbLogin as $log){
        echo $log['username'];
        if($log['username']==$login){
            $dbPassword = $connection->prepare("SELECT * FROM Admin WHERE username='$login'");
            $dbPassword->execute();
            $dbPassword = $dbPassword->fetch();
        }
    }

    if(password_verify($_POST['password'], $dbPassword['password']) || $_POST['password']==$dbPassword['password']){
        //if($dbPassword['password']==$_POST['password']){
        session_start();
        $_SESSION['username'] = $dbPassword['username'];
        $_SESSION['id'] = $dbPassword['id'];
        redirect("../View/Admin/adminView.php");
    }
    else{
        redirect("../View/Admin/Login.php?error=bad_login");
    }
}

function logout(){
    session_start();
    session_destroy();
    unset($_SESSION);
    redirect('Location: ../View/index.php?etat=disconnect');
}
