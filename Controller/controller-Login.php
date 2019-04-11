<?php
require_once "controller-GlobalFunctions.php";

if(isset($_GET['func'])) {
    $_GET['func']();
}

function login(){
    require_once "../Model/model-DB.php";

    //Makes sure the login and the password fields are not empty
    if (empty($_POST['login']) || empty($_POST['password'])) {
        redirect("../View/Admin/view-model-DB.php?error=bad_login");
    }

    $login = $_POST['login'];
/*
    $userList = $connection->prepare("SELECT username FROM Admin");
    $userList->execute();
    $userList = $userList->fetchAll();
*/
    $userList = getUsernameList();

    $adminTable = NULL;
    foreach ($userList as $username){
        //checks if the username input corresponds to an existing user in the admin table
        if ($username['username'] == $login){
            $adminTable = getAdminTable($login);
            //get all the info from the admin table corresponding to this username
        }
    }
    if ($adminTable == NULL){
        //if no username corresponds print out an error
        redirect("../View/Admin/view-model-DB.php?error=bad_login");
    }

    //verify the password hash is corresponding to the input password
    if(password_verify($_POST['password'], $adminTable['password'])){
        session_start();
        $_SESSION['username'] = $adminTable['username'];
        $_SESSION['id'] = $adminTable['id'];
        redirect("../View/Admin/view-IndexAdmin.php");
    }
    else{
        //if the input password doesn't match the hash print out an error
        redirect("../View/Admin/view-model-DB.php?error=bad_login");
    }
}

function logout(){
    session_start();
    session_destroy();
    unset($_SESSION);
    redirect("../View/index.php");
}
