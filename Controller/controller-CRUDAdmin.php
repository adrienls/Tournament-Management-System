<?php

require_once "controller-GlobalFunctions.php";
//use AdminList;
if(isset($_GET['func'])) {
    if(isset($_GET['id'])){
        $_GET['func']($_GET['id']);
    }
    else {
        $_GET['func']();
    }
}

function createAdmin() {
    //Connection to database
    $connection = connectDB();

    //Fields recovery
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Verification of all fields
    if(empty($username) || empty($password)) {
        redirect("../View/SuperAdmin/view-CreateAdmin.php?error=field_missing");
    }

    //Username verification
    $queryAdmins = $connection->prepare("SELECT * FROM Admin");
    $queryAdmins->execute();
    $admins = $queryAdmins->fetchAll();
    foreach ($admins as $admin) {
        if($username == $admin['username']){
            redirect("../View/SuperAdmin/view-CreateAdmin.php?error=name_used");
        }
    }

    //Informations sending
    $password_encrypted = password_hash($password, PASSWORD_DEFAULT);
    $insert = $connection->prepare("INSERT INTO Admin (id, username, password) VALUES (NULL, :username, :password)");
    $insert->bindParam(':username', $username);
    $insert->bindParam(':password', $password_encrypted);
    $insert->execute();
    redirect("../View/SuperAdmin/view-IndexSuperAdmin.php?success=new");
}

function updateAdmin($id){
    require_once "../Model/model-DB.php";
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) || empty($password)){
        redirect("../View/SuperAdmin/view-UpdateAdmin.php?id=$id&error=field_missing");
    }

    //Informations sending
    $password_encrypted = password_hash($password, PASSWORD_DEFAULT);

    // Il faut appeller la fonction updateadmin du model !!! a finir
    modelUpdateAdmin($username,$password_encrypted,$id);
}

function updateAdminView($id){
    require_once "../../Model/model-DB.php";

    $connection = connectDB();

    $queryAdmins = $connection->prepare("SELECT * FROM Admin WHERE id='$id'");
    $queryAdmins->execute();
    $admin = $queryAdmins->fetch();
    $connection = NULL;

    echo "Username : <input type='text' name='username' value='".$admin['username']."'/>
    <br>
    Password : <input type='password' name='password'/>
    <br>";
}