<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 22/03/2019
 * Time: 14:36
 */

session_start();

if(!isset($_SESSION['username'])){
    redirect("../index.php?error=bad_login");
}

else {
    require_once "../../Controller/CRUDTeam.php";
    echo "<h2>".$_GET['name']." Management</h2>";

    echo "<a href=\"newTeam.php?id=".$_GET["id"]."&&name=".$_GET['name']."\">New Team</a><br><br>";

    viewTeam($_GET["id"],$_GET['name']);

    if(isset($_GET['error'])){
        if($_GET['error'] == "max_number_of_team") {echo "<br><b style='color:darkred;'>Max number of team reach !</b><br>";}
    }
    if(isset($_GET['success'])){
        if($_GET['success'] == "new") {echo "<br><b style='color:green;'>Team created !</b><br>";}
        if($_GET['success'] == "update") {echo "<br><b style='color:green;'>Team updated !</b><br>";}
        if($_GET['success'] == "delete") {echo "<br><b style='color:green;'>Team erased !</b><br>";}
    }
    echo "<br><a href=\"./adminView.php\">Back</a>";
}