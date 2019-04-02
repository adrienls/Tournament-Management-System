<?php

require_once "../../Controller/GlobalFunctions.php";
require_once "../../Controller/CRUDTournament.php";

session_start();

if(!isset($_SESSION['username'])){
    redirect("../index.php?error=bad_login");
}

//SuperAdmin test
else {
    echo "<h2>Welcome ".$_SESSION['username']."</h2>";
    if($_SESSION['username']==="admin") {
        echo "<a href=\"superAdmin.php\">Admin Management</a><br><br>";
    }
    echo "<a href=\"newTournament.php\">New Tournament</a><br><br>";
    viewTournament();
    if(isset($_GET['success'])){
        if($_GET['success'] == "new") {echo "<br><b style='color:green;'>Tournament created !</b><br>";}
        if($_GET['success'] == "update") {echo "<br><b style='color:green;'>Tournament updated !</b><br>";}
        if($_GET['success'] == "delete") {echo "<br><b style='color:green;'>Tournament erased !</b><br>";}
    }
    echo "<br><a href=\"../../Controller/Login.php?func=logout\">Disconnect</a>";
}
?>
