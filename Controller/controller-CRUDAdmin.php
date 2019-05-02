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
    require_once "../Model/Database.php";
    //Connection to database
    //Fields recovery
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Verification of all fields
    if(empty($username) || empty($password)) {
        redirect("../View/SuperAdmin/view-CreateAdmin.php?error=field_missing");
    }

    //Username verification
    $admins = dbGetAdminList();
    foreach ($admins as $admin) {
        if($username == $admin['username']){
            redirect("../View/SuperAdmin/view-CreateAdmin.php?error=name_used");
        }
    }
    //Informations sending
    $password_encrypted = password_hash($password, PASSWORD_DEFAULT);
    dbInsertAdmin($username, $password_encrypted);
    redirect("../View/SuperAdmin/view-IndexSuperAdmin.php?success=new");
}

function updateAdmin($id){
    require_once "../Model/Database.php";
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) || empty($password)){
        redirect("../View/SuperAdmin/view-UpdateAdmin.php?id=$id&error=field_missing");
    }
    //Informations sending
    $password_encrypted = password_hash($password, PASSWORD_DEFAULT);

    dbUpdateAdmin($username, $password_encrypted, $id);
    redirect("../View/SuperAdmin/view-IndexSuperAdmin.php?success=update");
}

function updateAdminView($id){
    require_once "../Model/Database.php";
    $admin = dbGetAdminById($id);

    echo "Username : <input type='text' name='username' value='".$admin['username']."'/>
    <br>
    Password : <input type='password' name='password'/>
    <br>";
}

function deleteAdmin($id) {
    require_once "../Model/Database.php";
    dbDeleteAdmin($id);
}