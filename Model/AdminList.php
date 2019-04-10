<?php
/**
 * Created by PhpStorm.
 * User: adrien
 * Date: 04/04/19
 * Time: 09:02
 */

trait AdminList{
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
        redirect("../View/Admin/view-IndexSuperAdmin.php?success=update");
    }
}
class test{
    use AdminList;
    public function test()
    {
        return $this->getAdminList();
    }
}