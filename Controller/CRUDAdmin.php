<?php

require_once "GlobalFunctions.php";
require_once "../Model/DBConfig.php";

if(isset($_GET['func'])) {
    $_GET['func']();
}

function createAdmin() {
    //Connection to database
    $connection = connection();

    //Fields recovery
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Verification of all fields
    if(empty($username) || empty($password)) {
        redirect("../View/Admin/CRUDAdmin.php?error=field_missing");
    }

    //Username verification
    $queryAdmins = $connection->prepare("SELECT * FROM Admin");
    $queryAdmins->execute();
    $admins = $queryAdmins->fetchAll();
    foreach ($admins as $admin) {
        if($username == $admin['username']){
            redirect("../View/Admin/CRUDAdmin.php?error=name_used");
        }
    }

    //Informations sending
    $password_encrypted = password_hash($password, PASSWORD_DEFAULT);
    $insert = $connection->prepare("INSERT INTO Admin (id, username, password) VALUES (NULL, :username, :password)");
    $insert->bindParam(':username', $username);
    $insert->bindParam(':password', $password_encrypted);
    $insert->execute();
    redirect("../View/Admin/superAdmin.php");
}

function updateAdmin(){

}

function deleteAdmin(){

}