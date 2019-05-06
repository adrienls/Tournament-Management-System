<?php
require_once "controller-Global.php";

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
function readAdmin($id){
    require_once "../Model/Admin.php";
    $admin = getAdminById($id);
    return $admin["username"];
}
readAdmin(1);
function deleteAdmin($id) {
    require_once "../Model/Database.php";
    dbDeleteAdmin($id);
    redirect("../View/SuperAdmin/view-IndexSuperAdmin.php?success=delete");
}

function login(){
    require_once "../Model/Database.php";

    //Makes sure the login and the password fields are not empty
    if (empty($_POST['login']) || empty($_POST['password'])) {
        redirect("../View/Admin/view-Database.php?error=bad_login");
    }

    $login = $_POST['login'];
    /*
        $userList = $connection->prepare("SELECT username FROM Admin");
        $userList->execute();
        $userList = $userList->fetchAll();
    */
    $userList = dbGetUserList();
    $adminTable = NULL;
    foreach ($userList as $username){
        //checks if the username input corresponds to an existing user in the admin table
        if ($username['username'] == $login){
            $adminTable = dbGetAdminTable($login);
            //get all the info from the admin table corresponding to this username
        }
    }
    if ($adminTable == NULL){
        //if no username corresponds print out an error
        redirect("../View/Admin/view-Database.php?error=bad_login");
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
        redirect("../View/Admin/view-Database.php?error=bad_login");
    }
}

function logout(){
    session_start();
    session_destroy();
    unset($_SESSION);
    redirect("../View/index.php");
}
