<?php

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
    require_once "../Model/DBConfig.php";
    require_once "GlobalFunctions.php";
    $dbConfig=new DBConfig("localhost","Tournament-Management-System","testUser", "testPassword");
    $dbConfig->connectDB();
    $connection=$dbConfig->getDBConnection();
    //Test si le login et password ne sont pas vide

    if (empty($_POST['login']) || empty($_POST['password'])) {
        redirect("../View/Admin/Login.php?error=bad_login");
        echo"<br>";
    }
    $login=$_POST['login'];
    $dblogin = $connection->prepare("SELECT username FROM Admin");
    $dblogin->execute();
    $dblogin = $dblogin->fetchAll();
    var_dump($dblogin);
//echo $dblogin2[1]['login'];
    $dbpassword=NULL;
    foreach ($dblogin as $log ){
        echo $log['username'];
        if($log['username']==$login){
            //echo "easy";
            $dbpassword = $connection->prepare("SELECT * FROM Admin WHERE username='$login'");
            $dbpassword->execute();
            $dbpassword = $dbpassword->fetch();
            //var_dump($dbpassword);
            echo $dbpassword['password'];
            //header('Location: newuser.php');
        }
    }

    if(password_verify($_POST['password'],$dbpassword['password']) || $_POST['password']==$dbpassword['password']){
        //if($dbpassword['password']==$_POST['password']){
        session_start();
        $_SESSION['dbConnection'] = $dbConfig;
        $_SESSION['username'] = $dbpassword['username'];
        $_SESSION['id'] = $dbpassword['id'];
        redirect("../View/Admin/adminView.php");
    }
    else{
        redirect("../View/Admin/Login.php?error=bad_login");
        echo "<br>";
    }
}

function logout(){
    session_start();
    session_destroy();
    unset($_SESSION);
    header('Location: ../View/index.php?etat=disconnect');
}
