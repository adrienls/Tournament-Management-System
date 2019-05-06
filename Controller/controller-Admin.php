<?php
require_once "./controller-Global.php";
require_once "../Model/Admin.php";

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
    $admin = new Admin();
    $admin->insertAdmin($username, $password_encrypted);
    redirect("../View/SuperAdmin/view-IndexSuperAdmin.php?success=new");
}

function updateAdmin($id){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) || empty($password)){
        redirect("../View/SuperAdmin/view-UpdateAdmin.php?id=$id&error=field_missing");
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

function login(){
    //Makes sure the login and the password fields are not empty
    $login = $_POST['login'];
    var_dump($login);
    if (empty($login) || empty($_POST['password'])) {
        redirect("../View/Admin/view-Login.php?error=bad_login");
    }
    $userList = getUserList();
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
