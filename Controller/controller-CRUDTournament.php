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

function editTournament($id){
    require_once "../Model/model-DB.php";
    $tournament_name = $_POST['tournament_name'];
    $nb_team = $_POST['nb_team'];

    if(empty($tournament_name) || empty($nb_team)){
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=field_missing");
    }

    $oldNbTeam = oldTournament($id);

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

function deleteTeamForTournament($team_id) {
    require_once "../Model/model-DB.php";
    $infoTeam= modelInfoTeam($team_id);

    $pathLogo= $infoTeam['path_logo'];

    if(file_exists($pathLogo))
        unlink( $pathLogo ) ;
    modelDeleteTeam($team_id);
}

function deleteTournament($id){
    require_once "../Model/model-DB.php";

    require_once "controller-CRUDTeam.php";

    $teams = getTeamList($id);
    foreach ($teams as $team) {
        deleteTeamForTournament($team['id']);
    }
    modelDeleteTournament($id);
}

function testNumberMaxTeam($tournament_id){
    require_once "../../../Model/model-DB.php";

    $nbTeamMax = nbTeamMax($tournament_id);
    $nbTeam = nbTeam($tournament_id);

    if($nbTeam<$nbTeamMax){
        return 0;
    }
    else{
        return 1;
    }
}

function generateDays($tournament_id) {
    require_once "../Model/model-DB.php";

    $teams = getTeamList($tournament_id);

    $nbDays = count($teams);
    if ($nbDays % 2 == 0) {
        $nbDays--;
    }

    // Days creation
    for ($i = 1; $i <= $nbDays; $i++) {
        insertDay($tournament_id,$i);
    }

    $days = dbGetDayList($tournament_id);
    /*foreach ($days as $day) {
        if($day['day_number'] != 1) {
            //
        }
        //Generate Matches
        $matches =

        //Insert Matches
        insertPlanning($day['day_id'], $teams[0]['name'], $teams[1]['id']);
    }*/
}
