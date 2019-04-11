<?php
/**
 * Created by PhpStorm.
 * User: arthu
 * Date: 11/04/2019
 * Time: 11:25
 */

class Login
{
    public function getUsernameList(){
        $connection = connectDB();
        //Teams recovery
        $userList = $connection->prepare("SELECT username FROM Admin");
        $userList->execute();
        $userList = $userList->fetchAll();

        $connection = NULL;
        return $userList;
    }
    public function getAdminTable($login){
        $connection = connectDB();
        //Teams recovery
        $adminTable = $connection->prepare("SELECT * FROM Admin WHERE username='$login'");
        $adminTable->execute();
        $adminTable = $adminTable->fetch();

        $connection = NULL;
        return $adminTable;
    }
}