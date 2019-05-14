<?php
require_once "controller-Global.php";
require_once __DIR__."/../Model/Admin.php";

if (!isIdentified() || $_SESSION['username']!="admin") {
    redirect("../View/index.php?error=access_denied");
}

if(isset($_GET['func'])) {
    if(isset($_GET['id'])){
        $_GET['func']($_GET['id']);
    }
    else {
        $_GET['func']();
    }
}

function createAdmin() {
    //Fields recovery
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    //Verification of all fields
    if(empty($username) || empty($password) || empty($confirmPassword)) {
        redirect("../View/SuperAdmin/view-CreateAdmin.php?error=field_missing");
    }
    if($password != $confirmPassword) {
        redirect("../View/SuperAdmin/view-CreateAdmin.php?error=mismatch");
    }
    if($username == $password) {
        redirect("../View/SuperAdmin/view-CreateAdmin.php?error=identical");
    }
    //Username verification
    $admins = getAdminList();
    foreach ($admins as $admin) {
        if($username == $admin->getUsername()){
            redirect("../View/SuperAdmin/view-CreateAdmin.php?error=name_used");
        }
    }
    //Informations sending
    $password_encrypted = password_hash($password, PASSWORD_DEFAULT);
    $admin = new Admin();
    $admin->insertAdmin($username, $password_encrypted);
    redirect("../View/SuperAdmin/view-IndexSuperAdmin.php?success=new");
}

function updateAdmin($id){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    //Verification of all fields
    if(empty($username) || empty($password) || empty($confirmPassword)) {
        redirect("../View/SuperAdmin/view-UpdateAdmin.php?id=$id&error=field_missing");
    }
    if($password != $confirmPassword) {
        redirect("../View/SuperAdmin/view-UpdateAdmin.php?id=$id&error=mismatch");
    }
    if($username == $password) {
        redirect("../View/SuperAdmin/view-UpdateAdmin.php?id=$id&error=identical");
    }
    //Username verification
    if (readAdmin($id) != $username) {
        $admins = getAdminList();
        foreach ($admins as $admin) {
            if($username == $admin->getUsername()){
                redirect("../View/SuperAdmin/view-UpdateAdmin.php?id=$id&error=name_used");
            }
        }
    }
    //Informations sending
    $password_encrypted = password_hash($password, PASSWORD_DEFAULT);
    $admin = new Admin();
    $admin->updateAdmin($username, $password_encrypted, $id);
    redirect("../View/SuperAdmin/view-IndexSuperAdmin.php?success=update");
}
function readAdmin($id){
    $admin = getAdminById($id);
    return $admin->getUsername();
}
function deleteAdmin($id) {
    $admin = new Admin();
    $admin->deleteAdmin($id);
    redirect("../View/SuperAdmin/view-IndexSuperAdmin.php?success=delete");
}
