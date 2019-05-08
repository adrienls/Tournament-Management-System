<?php
require_once "../../Model/Database.php";
require_once "../../Controller/controller-Admin.php";
session_start();

if(isset($_SESSION['username'])){
    if($_SESSION['username']==="admin") {
        echo '<a href="view-CreateAdmin.php">New Admin</a><br/><br/>';
        //viewAdmin();

        // test pour le trait qui est ok
        $admins= getAdminList();
        //Display
        echo "<table style=\"text-align:center\"><tr><th>Username</th></tr>";
        foreach($admins as $admin) {
            if ($admin->getUsername() != "admin") {
                echo "<tr>
            <td>".$admin->getUsername()."</td>
            <td><a href=\"view-UpdateAdmin.php?id=".$admin->getId()."\">Edit</a></td>
            <td><a href=\"../../Controller/controller-Admin.php?func=deleteAdmin&id=".$admin->getId()."\">Delete</a></td>
            </tr>";
            }
        }
        echo "</table>";


        if(isset($_GET['success'])){
            if($_GET['success'] == "new") {echo "<br><b style='color:green;'>Admin created !</b><br>";}
            if($_GET['success'] == "update") {echo "<br><b style='color:green;'>Admin updated !</b><br>";}
            if($_GET['success'] == "delete") {echo "<br><b style='color:green;'>Admin erased !</b><br>";}
        }
        echo "<br><a href='../Admin/view-IndexAdmin.php'>Back</a>";
    }
    else {
        redirect("view-IndexAdmin.php?error=access_denied");
    }
}

else {
  redirect("../index.php");
}
