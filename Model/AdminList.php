<?php
/**
 * Created by PhpStorm.
 * User: arthu
 * Date: 11/04/2019
 * Time: 15:33
 */

class AdminList
{
    public function getAdminList(){
        $connection = connectDB();
        //Teams recovery
        $queryAdmins = $connection->prepare("SELECT * FROM Admin ");
        $queryAdmins->execute();
        $admins = $queryAdmins->fetchAll();

        $connection = NULL;
        return $admins;
    }
    public function deleteAdmin($tournament_id){
        $connection = connectDB();
        $delete = $connection->prepare("DELETE FROM Admin WHERE id='$tournament_id'");
        $delete->execute();

        $connection = NULL;
        redirect("../View/Admin/view-IndexSuperAdmin.php?success=delete");
    }
    public function updateAdmin($username, $password, $id){
        $connection = connectDB();
        $insert = $connection->prepare("UPDATE Admin SET username='$username', password='$password' WHERE id='$id'");
        $insert->execute();

        $connection = NULL;
        redirect("../View/SuperAdmin/view-IndexSuperAdmin.php?success=update");
    }

}