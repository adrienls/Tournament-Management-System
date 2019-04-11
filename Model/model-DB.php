<?php
/**
 * Created by PhpStorm.
 * User: arthu
 * Date: 11/04/2019
 * Time: 11:25
 */

//function connectDB($host="localhost", $dbName="Tournament-Management-System", $user="testUser", $password="testPassword"){
function connectDB($host="localhost", $dbName="Tournament-Management-System", $user="testUser", $password="testPassword"){
    $dsn = 'mysql:host='.$host.';dbname='.$dbName;
    try {
        $dbConnection = new PDO($dsn, $user, $password);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
    catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
        return NULL;
    }
}
function getUsernameList(){
    $connection = connectDB();
    //Teams recovery
    $userList = $connection->prepare("SELECT username FROM Admin");
    $userList->execute();
    $userList = $userList->fetchAll();

    $connection = NULL;
    return $userList;
}
function getAdminTable($login){
    $connection = connectDB();
    //Teams recovery
    $adminTable = $connection->prepare("SELECT * FROM Admin WHERE username='$login'");
    $adminTable->execute();
    $adminTable = $adminTable->fetch();

    $connection = NULL;
    return $adminTable;
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
function deleteAdmin($tournament_id){
    $connection = connectDB();
    $delete = $connection->prepare("DELETE FROM Admin WHERE id='$tournament_id'");
    $delete->execute();

    $connection = NULL;
    redirect("../View/Admin/view-IndexSuperAdmin.php?success=delete");
}
function modelUpdateAdmin($username, $password, $id){
    $connection = connectDB();
    $insert = $connection->prepare("UPDATE Admin SET username='$username', password='$password' WHERE id='$id'");
    $insert->execute();

    $connection = NULL;
    redirect("../View/SuperAdmin/view-IndexSuperAdmin.php?success=update");
}
function modelUpdateAdminView($id){
    $connection = connectDB();

    $queryAdmins = $connection->prepare("SELECT * FROM Admin WHERE id='$id'");
    $queryAdmins->execute();
    $admin = $queryAdmins->fetch();

    $connection = NULL;
    return $admin;

}