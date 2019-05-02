<?php

class Admin
{
    private $id;
    private $username;
    private $password;

    public function getId(){ return $this->id; }
    public function getUsername(){ return $this->username; }
    public function getPassword(){ return $this->password; }

    public function insertAdmin($username, $password){
        $connection = connectDB();
        $insertAdmin = $connection->prepare("INSERT INTO Admin (id, username, password) VALUES (NULL, :username, :password)");
        $insertAdmin->bindParam(':username', $username);
        $insertAdmin->bindParam(':password', $password);
        $insertAdmin->execute();
        $connection = NULL;
    }
    public function updateAdmin($id, $username, $password){
        $connection = connectDB();
        $updateAdmin = $connection->prepare("UPDATE Admin SET username='$username', password='$password' WHERE id='$id'");
        $updateAdmin->execute();
        $connection = NULL;
    }
    public function deleteAdmin($id){
        $connection = connectDB();
        $delete = $connection->prepare("DELETE FROM Admin WHERE id='$id'");
        $delete->execute();
        $connection = NULL;
        redirect("../View/SuperAdmin/view-IndexSuperAdmin.php?success=delete");
    }

    public function __toString(){
        $description = "Admin table: ".$this."</br>
        id: ".$this->id."</br>
        username: ".$this->username."</br>
        password: ".$this->password."</br>";
        return $description;
    }
}

function getUserList(){
    $connection = connectDB();
    $userList = $connection->prepare("SELECT username FROM Admin");
    $userList->execute();
    $userList = $userList->fetchAll(PDO::FETCH_CLASS, "Admin");
    $connection = NULL;
    return $userList;
}
function getAdminTable($login){
    $connection = connectDB();
    $adminTable = $connection->prepare("SELECT * FROM Admin WHERE username='$login'");
    $adminTable->execute();
    $adminTable = $adminTable->fetchObject("Admin");
    $connection = NULL;
    return $adminTable;
}
function getAdminList(){
    $connection = connectDB();
    $adminList = $connection->prepare("SELECT * FROM Admin ");
    $adminList->execute();
    $adminList = $adminList->fetchAll(PDO::FETCH_CLASS, "Admin");
    $connection = NULL;
    return $adminList;
}
function getAdminById($id){
    $connection = connectDB();
    $adminById = $connection->prepare("SELECT * FROM Admin WHERE id='$id'");
    $adminById->execute();
    $adminById = $adminById->fetchObject("Admin");
    $connection = NULL;
    return $adminById;
}