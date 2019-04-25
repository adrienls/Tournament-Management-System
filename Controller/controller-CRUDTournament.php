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
    require_once "../Model/model-DB.php";

    $tournamentName = $_POST['tournamentName'];
    $nbTeam = $_POST['nbTeam'];

    if(empty($tournamentName) || $nbTeam==0){
        redirect("../View/Admin/Tournament/view-CreateTournament.php?error=field_missing_or_nb_invalid");
    }

    //Name verification
    $dbTournament = dbGetTournamentList();
    foreach ($dbTournament as $tournament) {
        if($tournamentName == $tournament['name']){
            redirect("../View/Admin/Tournament/view-CreateTournament.php?error=name_used");
        }
    }

    //Informations sending
    insertTournament($tournamentName, $nbTeam);
    redirect("../View/Admin/view-IndexAdmin.php?success=new");

}

/*function editTournamentView($id) {
    require_once "../../../Model/model-DB.php";
    $tournament = modelEditTournamentView($id);
    return $tournament;

}*/

function editTournament($id){
    require_once "../Model/model-DB.php";
    $tournament_name = $_POST['tournament_name'];
    $nb_team = $_POST['nb_team'];

    if(empty($tournament_name) || empty($nb_team)){
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=field_missing");
    }

    $oldNbTeam = oldTournament($id);

    //var_dump($nb_team);
    //var_dump($oldNbTeam);
    //Verification of the number of teams
    if($nb_team < 0) {
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=number_invalid");
    }
    if($nb_team<$oldNbTeam) {
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=number_use");
    }

    //Informations sending
    modelUpdateTournament($tournament_name,$nb_team,$id);
}

function deleteTournament($id){
    require_once "../Model/model-DB.php";

    require_once "controller-CRUDTeam.php";

    $teams = getTeamList($id);
    foreach ($teams as $team) {
        deleteTeam($team['id']);
    }
    modelDeleteTournament($id);
}

/*function deleteTeam($team_id) {
    $connection = connectDB();
    $queryIdPathTournament = $connection->prepare("SELECT tournament_id, path_logo FROM Team WHERE id='$team_id'");
    $queryIdPathTournament->execute();
    $infoTeam= $queryIdPathTournament->fetch();

    $pathLogo= $infoTeam['path_logo'];
    if(file_exists($pathLogo))
        unlink($pathLogo);

    $delete = $connection->prepare("DELETE FROM Team WHERE id='$team_id'");
    $delete->execute();
}*/

/*function viewTournament()
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
}*/

