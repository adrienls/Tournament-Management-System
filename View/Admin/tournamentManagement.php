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
    echo "<h2>Welcome ".$_SESSION['username']." on the page of the tournament</h2>";

    viewTeam($_GET["id"]);

    echo "<a href=\"newTeam.php?id=".$_GET["id"]."\">New Team</a><br><br>";

    if(isset($_GET['error'])){
        if($_GET['error'] == "max_number_of_team") {echo "<br><b style='color:darkred;'>Max number of team reach !</b><br>";}
    }
    if(isset($_GET['success'])){
        if($_GET['success'] == "new") {echo "<br><b style='color:green;'><Team></Team> created !</b><br>";}
        if($_GET['success'] == "update") {echo "<br><b style='color:green;'>Team updated !</b><br>";}
        if($_GET['success'] == "delete") {echo "<br><b style='color:green;'>Team erased !</b><br>";}

    }
    echo "<br><a href=\"./adminView.php\">Back</a>";
}