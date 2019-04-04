<?php

require_once "controller-GlobalFunctions.php";

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
        redirect("../View/Admin/view-CreateAdmin.php?error=field_missing");
    }

    //Username verification
    $queryAdmins = $connection->prepare("SELECT * FROM Admin");
    $queryAdmins->execute();
    $admins = $queryAdmins->fetchAll();
    foreach ($admins as $admin) {
        if($username == $admin['username']){
            redirect("../View/Admin/view-CreateAdmin.php?error=name_used");
        }
    }

    //Informations sending
    $password_encrypted = password_hash($password, PASSWORD_DEFAULT);
    $insert = $connection->prepare("INSERT INTO Admin (id, username, password) VALUES (NULL, :username, :password)");
    $insert->bindParam(':username', $username);
    $insert->bindParam(':password', $password_encrypted);
    $insert->execute();
    redirect("../View/Admin/view-IndexSuperAdmin.php?success=new");
}

function updateAdmin($id){

    $connection = connectDB();

    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) || empty($password)){
        redirect("../View/Admin/view-UpdateAdmin.php?error=field_missing");
    }

    //Informations sending
    $password_encrypted = password_hash($password, PASSWORD_DEFAULT);
    $insert = $connection->prepare("UPDATE Admin SET username='$username', password='$password_encrypted' WHERE id='$id'");
    $insert->execute();
    redirect("../View/Admin/view-IndexSuperAdmin.php?success=update");

}

function updateAdminView($id){

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

function deleteAdmin($id){
    $connection = connectDB();
    $delete = $connection->prepare("DELETE FROM Admin WHERE id='$id'");
    $delete->execute();

    $connection = NULL;
    redirect("../View/Admin/view-IndexSuperAdmin.php?success=delete");
}

function getAdminList(){

    $connection = connectDB();

    //Teams recovery
    $queryAdmins = $connection->prepare("SELECT * FROM Admin ");
    $queryAdmins->execute();
    $admins = $queryAdmins->fetchAll();

    $connection = NULL;
    return $admins;
}
