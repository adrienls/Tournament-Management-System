<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 22/03/2019
 * Time: 14:36
 */

session_start();

if(!isset($_SESSION['username'])){
    redirect("../../index.php?error=bad_login");
}

else {
    require_once "../../../Controller/controller-CRUDTournament.php";
    require_once "../../../Model/Database.php";

    echo "<h2>".$_GET['name']." Management</h2>";
    echo "<a href=\"../Team/view-CreateTeam.php?id=".$_GET["id"]."&&name=".$_GET['name']."\">New Team</a><br><br>";

    //Tournaments Recovery
    $teams = dbGetTeamList($_GET["id"]);
    //Display
    echo "<table><tr><th>Name</th><th>NbOfVisit</th><th>Logo</th></tr>";
    foreach($teams as $team) {
        echo "<tr>
            <td>".$team['name']."</td>
            <td>".$team['nb_visit']."</td>
            <td></td>
            <td><a href=\"../Team/view-UpdateTeam.php?id=".$team['id']."&&name=".$_GET['name']."\">Edit</a></td>
            <td><a href=\"../../../Controller/controller-CRUDTeam.php?func=deleteTeam&&id=".$team['id']."&&name=".$_GET['name']."\">Delete</a></td>
            </tr>";
    }
    echo "</table>";

    if(isset($_GET['error'])){
        if($_GET['error'] == "max_number_of_team") {echo "<br><b style='color:darkred;'>Max number of team reach !</b><br>";}
    }
    if(isset($_GET['success'])){
        if($_GET['success'] == "new") {echo "<br><b style='color:green;'>Team created !</b><br>";}
        if($_GET['success'] == "update") {echo "<br><b style='color:green;'>Team updated !</b><br>";}
        if($_GET['success'] == "delete") {echo "<br><b style='color:green;'>Team erased !</b><br>";}
        if($_GET['success'] == "generate") {echo "<br><b style='color:green;'>Days & Matches generated !</b><br>";}
    }
    if(testNumberMaxTeam($_GET['id'])){
        echo "<br><a href=\"../../../Controller/controller-CRUDTournament.php?func=generateDays&id=".$_GET["id"]."&name=".$_GET["name"]."\">GenerateDays</a></br>";
    }
    echo "<a href='../view-IndexAdmin.php'>Back</a>";
}