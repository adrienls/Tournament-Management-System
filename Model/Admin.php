<?php
require_once "./Database.php";

class Admin extends Database
{
    private $id;
    private $username;
    private $password;

    public function getId(){ return $this->id; }
    public function getUsername(){ return $this->username; }
    public function getPassword(){ return $this->password; }

    public function insertAdmin($username, $password){
        $insertAdmin = $this->connection->prepare("INSERT INTO Admin (id, username, password) VALUES (NULL, :username, :password)");
        $insertAdmin->bindParam(':username', $username);
        $insertAdmin->bindParam(':password', $password);
        $insertAdmin->execute();
    }
    public function updateAdmin($id, $username, $password){
        $updateAdmin = $this->connection->prepare("UPDATE Admin SET username='$username', password='$password' WHERE id='$id'");
        $updateAdmin->execute();
    }
    //ISSUE WITH REDIRECT NOT SUPPOSED TO BE THERE
    public function deleteAdmin($id){
        $delete = $this->connection->prepare("DELETE FROM Admin WHERE id='$id'");
        $delete->execute();
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
    $db = new Database();
    $userList = $db->getConnection()->prepare("SELECT username FROM Admin");
    $userList->execute();
    $userList = $userList->fetchAll(PDO::FETCH_CLASS, "Admin");
    return $userList;
}
function getAdminTable($login){
    $db = new Database();
    $adminTable = $db->getConnection()->prepare("SELECT * FROM Admin WHERE username='$login'");
    $adminTable->execute();
    $adminTable = $adminTable->fetchObject("Admin");
    return $adminTable;
}
function getAdminList(){
    $db = new Database();
    $adminList = $db->getConnection()->prepare("SELECT * FROM Admin ");
    $adminList->execute();
    $adminList = $adminList->fetchAll(PDO::FETCH_CLASS, "Admin");
    return $adminList;
}
function getAdminById($id){
    $db = new Database();
    $adminById = $db->getConnection()->prepare("SELECT * FROM Admin WHERE id='$id'");
    $adminById->execute();
    $adminById = $adminById->fetchObject("Admin");
    return $adminById;
}