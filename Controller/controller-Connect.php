<?php
require_once "controller-Global.php";
require_once __DIR__."/../Model/Admin.php";

if(isset($_GET['func'])) {
    $_GET['func']();
}

function login(){
    require_once __DIR__."/../Model/Admin.php";
    //Makes sure the login and the password fields are not empty
    $login = $_POST['login'];
    if (empty($login) || empty($_POST['password'])) {
        redirect("../View/Admin/view-Login.php?error=bad_login");
    }
    $userList = getUserList();
    var_dump($userList);
    $adminTable = NULL;
    foreach ($userList as $username){
        //checks if the username input corresponds to an existing user in the admin table
        if ($username->getUsername() == $login){
            $adminTable = getAdminTable($login);
            //get all the info from the admin table corresponding to this username
        }
    }
    if ($adminTable == NULL){
        //if no username corresponds print out an error
        redirect("../View/Admin/view-Login.php?error=bad_login");
    }
    //verify the password hash is corresponding to the input password
    if(password_verify($_POST['password'], $adminTable->getPassword())){
        session_start();
        $_SESSION['username'] = $adminTable->getUsername();
        $_SESSION['id'] = $adminTable->getId();
        redirect("../View/Admin/view-IndexAdmin.php");
    }
    else{
        //if the input password doesn't match the hash print out an error
        redirect("../View/Admin/view-Login.php?error=bad_login");
    }
}

function logout(){
    session_start();
    session_destroy();
    unset($_SESSION);
    redirect("../View/index.php");
}