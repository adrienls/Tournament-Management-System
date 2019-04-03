<?php

require_once "../../Controller/CRUDAdmin.php";

session_start();

if(isset($_SESSION['username'])){
    if($_SESSION['username']==="admin") {
        echo "<h2>Admin Management</h2>
        <a href=\"newAdmin.php\">New Admin</a><br><br>";
        viewAdmin();
        if(isset($_GET['success'])){
            if($_GET['success'] == "new") {echo "<br><b style='color:green;'>Admin created !</b><br>";}
            if($_GET['success'] == "update") {echo "<br><b style='color:green;'>Admin updated !</b><br>";}
            if($_GET['success'] == "delete") {echo "<br><b style='color:green;'>Admin erased !</b><br>";}
        }
        echo "<br><a href=\"adminView.php\">Back</a>";
    }
    else {
        redirect("adminView.php?error=access_denied");
    }
}

else {
  redirect("../index.php");
}
