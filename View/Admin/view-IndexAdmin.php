<?php
require_once "../../Controller/controller-Global.php";
require_once "../../Controller/controller-Tournament.php";
require_once "../../Controller/controller-Admin.php";
session_start();

if(isset($_SESSION['username'])){
    echo "<h2>Welcome ".$_SESSION['username']."</h2>";
    if($_SESSION['username']==="admin") {
        echo '<a href="../SuperAdmin/view-IndexSuperAdmin.php">Admin Management</a><br/><br/>';
    }
    echo '<a href="Tournament/view-CreateTournament.php">New Tournament</a><br/><br/>';

    $tournaments = getTournamentList();
    echo "<table style=\"text-align:center\"><tr><th>Name</th><th>NbTeamsMax</th></tr>";
    foreach ($tournaments as $tournament) {
        $id = $tournament->getId();
        $name = $tournament->getName();
        $nb_team = $tournament->getNbTeam();
        echo "<tr>
            <td><a href=\"../Admin/Tournament/view-IndexTournament.php?id=".$id."&name=".$name."\">".$name."</td>
            <td>".$nb_team."</td>
            <td><a href=\"../Admin/Tournament/view-UpdateTournament.php?id=".$id."\">Edit</a></td>
            <td><a href=\"../../Controller/controller-Tournament.php?func=deleteTournament&id=".$id."\">Delete</a></td>
            </tr>";
    }
    echo "</table>";
    //Display
    if(isset($_GET['success'])){
        if($_GET['success'] == "new") {echo "<br><b style='color:green;'>Tournament created !</b><br>";}
        if($_GET['success'] == "update") {echo "<br><b style='color:green;'>Tournament updated !</b><br>";}
        if($_GET['success'] == "delete") {echo "<br><b style='color:green;'>Tournament erased !</b><br>";}
    }
    echo '<br><a href="../../Controller/controller-Admin.php?func=logout">Disconnect</a>';
}
else {
    redirect("view-Login.php?error");
}