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
    $tournaments= dbGetTournamentList();

    echo "<table><tr><th>Name</th><th>NbTeamsMax</th></tr>";
    foreach ($tournaments as $tournament) {
        echo "<tr>
            <td><a href=\"../Admin/Tournament/view-IndexTournament.php?id=" . $tournament['id'] . "&&name=" . $tournament['name'] . "\">" . $tournament['name'] . "</td>
            <td>" . $tournament['nb_team'] . "</td>
            <td><a href=\"../Admin/Tournament/view-UpdateTournament.php?id=" . $tournament['id'] . "\">Edit</a></td>
            <td><a href=\"../../Controller/Controller-CRUDTournament.php?func=deleteTournament&&id=" . $tournament['id'] . "\">Delete</a></td>
            </tr>";
    }
    echo "</table>";
    //Display

    if(isset($_GET['success'])){
        if($_GET['success'] == "new") {echo "<br><b style='color:green;'>Tournament created !</b><br>";}
        if($_GET['success'] == "update") {echo "<br><b style='color:green;'>Tournament updated !</b><br>";}
        if($_GET['success'] == "delete") {echo "<br><b style='color:green;'>Tournament erased !</b><br>";}
    }
    echo '<a href="../../Controller/controller-Login.php?func=logout">Disconnect</a>';
}
?>
