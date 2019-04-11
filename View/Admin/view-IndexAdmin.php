<?php

require_once "../../Model/model-DB.php";
require_once "../../Controller/controller-GlobalFunctions.php";
require_once "../../Controller/controller-CRUDTournament.php";
require_once "../../Controller/controller-CRUDAdmin.php";
//use AdminList;


session_start();

if(!isset($_SESSION['username'])){
    redirect("../index.php?error=bad_login");
}

//SuperAdmin test
else {
    echo "<h2>Welcome ".$_SESSION['username']."</h2>";
    if($_SESSION['username']==="admin") {
        echo '<a href="../SuperAdmin/view-IndexSuperAdmin.php">Admin Management</a><br/><br/>';
    }
    echo '<a href="Tournament/view-CreateTournament.php">New Tournament</a><br/><br/>';

    //$admins = $this->getAdminList();

    // test pour le trait qui est ok
    $admins= getAdminList();


    //Display
    echo "<table><tr><th>Username</th></tr>";
    foreach($admins as $admin) {
        if ($admin['username'] != "admin") {
            echo "<tr>
            <td>".$admin['username']."</td>
            <td><a href=\"view-UpdateAdmin.php?id=".$admin['id']."\">Edit</a></td>
            <td><a href=\"../../Controller/CRUDAdmin.php?func=deleteAdmin&&id=".$admin['id']."\">Delete</a></td>
            </tr>";
        }
    }
    echo "</table>";

    if(isset($_GET['success'])){
        if($_GET['success'] == "new") {echo "<br><b style='color:green;'>Tournament created !</b><br>";}
        if($_GET['success'] == "update") {echo "<br><b style='color:green;'>Tournament updated !</b><br>";}
        if($_GET['success'] == "delete") {echo "<br><b style='color:green;'>Tournament erased !</b><br>";}
    }
    echo '<a href="../../Controller/controller-Login.php?func=logout">Disconnect</a>';
}
?>
