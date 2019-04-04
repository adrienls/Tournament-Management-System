<?php

require_once "controller-GlobalFunctions.php";

if(isset($_GET['func'])) {
    if(isset($_GET['id'])){
        $_GET['func']($_GET['id']);
    }
    else {
        $_GET['func']();
    }
}

function createTournament() {

    $connection = connectDB();

    $tournamentName = $_POST['tournamentName'];
    $nbTeam = $_POST['nbTeam'];

    if(empty($tournamentName) || $nbTeam==0){
        redirect("../View/Admin/Tournament/view-CreateTournament.php?error=field_missing_or_nb_invalid");
    }

    //Name verification
    $queryTournament = $connection->prepare("SELECT * FROM Tournament");
    $queryTournament->execute();
    $dbTournament = $queryTournament->fetchAll();
    foreach ($dbTournament as $tournament) {
        if($tournamentName == $tournament['name']){
            redirect("../View/Admin/Tournament/view-CreateTournament.php?error=name_used");
        }
    }

    //Informations sending
    $insert = $connection->prepare("INSERT INTO Tournament (id, name, nb_team) VALUES (NULL, :name, :nb_team)");
    $insert->bindParam(':name', $tournamentName);
    $insert->bindParam(':nb_team', $nbTeam);
    $insert->execute();
    redirect("../View/Admin/Tournament/view-IndexAdmin.php?success=new");

}

function editTournamentView($id) {

    $connection = connectDB();

    $queryTournament = $connection->prepare("SELECT * FROM Tournament WHERE id='$id'");
    $queryTournament->execute();
    $tournament = $queryTournament->fetch();

    echo "Name : <input type='text' name='tournament_name' value='".$tournament['name']."'/>
    <br>
    Number of team : <input type='number' step=\"1\" min=\"0\" name='nb_team' value='".$tournament['nb_team']."'/>
    <br>";

}

function editTournament($id){

    $connection = connectDB();

    $tournament_name = $_POST['tournament_name'];
    $nb_team = $_POST['nb_team'];

    if(empty($tournament_name) || empty($nb_team)){
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=field_missing");
    }

    $queryNbTeam = $connection->prepare("SELECT * FROM Team WHERE tournament_id='$id'");
    $queryNbTeam->execute();
    $oldNbTeam = $queryNbTeam->rowCount();

    var_dump($nb_team);
    var_dump($oldNbTeam);
    //Verification of the number of teams
    if($nb_team < 0) {
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=number_invalid");
    }
    if($nb_team<$oldNbTeam) {
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=number_use");
    }

    //Informations sending
    $insert = $connection->prepare("UPDATE Tournament SET name='$tournament_name', nb_team='$nb_team' WHERE id='$id'");
    $insert->execute();
    redirect("../View/Admin/view-IndexAdmin.php?success=update");
}

function deleteTournament($id){

    require_once "controller-CRUDTeam.php";

    $connection = connectDB();

    $queryTeams = $connection->prepare("SELECT * FROM Team WHERE tournament_id='$id'");
    $delete = $connection->prepare("DELETE FROM Tournament WHERE id='$id'");
    $queryTeams->execute();
    $teams = $queryTeams->fetchAll();
    foreach ($teams as $team) {
        deleteTeam($team['id']);
    }
    $delete->execute();
    redirect("../View/Admin/view-IndexAdmin.php?success=delete");
}

function deleteTeam($team_id) {
    $connection = connectDB();
    $queryIdPathTournament = $connection->prepare("SELECT tournament_id, path_logo FROM Team WHERE id='$team_id'");
    $queryIdPathTournament->execute();
    $infoTeam= $queryIdPathTournament->fetch();

    $pathLogo= $infoTeam['path_logo'];
    if(file_exists($pathLogo))
        unlink($pathLogo);

    $delete = $connection->prepare("DELETE FROM Team WHERE id='$team_id'");
    $delete->execute();
}

function viewTournament()
{

    $connection = connectDB();

    //Tournaments Recovery
    $queryTournaments = $connection->prepare("SELECT * FROM Tournament ");
    $queryTournaments->execute();
    $tournaments = $queryTournaments->fetchAll();

    //Display
    echo "<table><tr><th>Name</th><th>NbTeamsMax</th></tr>";
    foreach ($tournaments as $tournament) {
        echo "<tr>
            <td><a href=\"../View/Admin/Tournament/view-IndexTournament.php?id=" . $tournament['id'] . "&&name=" . $tournament['name'] . "\">" . $tournament['name'] . "</td>
            <td>" . $tournament['nb_team'] . "</td>
            <td><a href=\"../View/Admin/Tournament/view-UpdateTournament.php?id=" . $tournament['id'] . "\">Edit</a></td>
            <td><a href=\"./Controller-CRUDTournament.php?func=deleteTournament&&id=" . $tournament['id'] . "\">Delete</a></td>
            </tr>";
    }
    echo "</table>";

    $connection = NULL;
}

