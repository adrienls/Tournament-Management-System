<?php

require_once "controller-Global.php";

if(isset($_GET['func'])) {
    if(isset($_GET['id'])){
        $_GET['func']($_GET['id']);
    }
    else {
        $_GET['func']();
    }
}

function createTournament() {
    require_once "../Model/Database.php";

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
    dbInsertTournament($tournamentName, $nbTeam);
    redirect("../View/Admin/view-IndexAdmin.php?success=new");
}

function editTournament($id){
    require_once "../Model/Database.php";
    $tournament_name = $_POST['tournament_name'];
    $nb_team = $_POST['nb_team'];

    if(empty($tournament_name) || empty($nb_team)){
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=field_missing");
    }

    $oldNbTeam = dbGetNbTeamMax($id);

    //Verification of the number of teams
    if($nb_team < 0) {
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=number_invalid");
    }
    if($nb_team<$oldNbTeam) {
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=number_use");
    }

    //Informations sending
    dbUpdateTournament($tournament_name,$nb_team,$id);
    redirect("../View/Admin/view-IndexAdmin.php?success=update");
}

function deleteTeamForTournament($team_id) {
    require_once "../Model/Database.php";
    $infoTeam= dbGetInfoTeam($team_id);

    $pathLogo= $infoTeam['path_logo'];

    if(file_exists($pathLogo)){
        unlink( $pathLogo ) ;
    }
    dbDeleteTeam($team_id);
}

function deleteTournament($id){
    require_once "../Model/Database.php";
    require_once "controller-Team.php";

    $teams = dbGetTeamList($id);
    foreach ($teams as $team) {
        deleteTeamForTournament($team['id']);
    }
    dbDeleteTournament($id);
    redirect("../View/Admin/view-IndexAdmin.php?success=deleteTournament");
}

function testNumberMaxTeam($tournament_id){
    require_once "../Model/Database.php";

    $nbTeamMax = dbGetNbTeamMax($tournament_id);
    $nbTeam = dbGetNbTeam($tournament_id);

    if($nbTeam<$nbTeamMax){
        return 0;
    }
    else{
        return 1;
    }
}

function generateDays($tournament_id) {
    require_once "../Model/Database.php";

    $teams = dbGetTeamList($tournament_id);

    $nbTeams = count($teams);
    $nbDays = ($nbTeams % 2 == 0) ? $nbTeams-1 : $nbTeams;

    // Days creation
    for ($i = 1; $i <= $nbDays; $i++) {
        dbInsertDay($tournament_id,$i);
    }
    $days = dbGetDayList($tournament_id);

    $matches = array();
    $j = 0;
    foreach ($teams as $team) {
        $nbTeams = count($teams);
        for ($i = 1; $i < $nbTeams; $i++) {
            if ($teams[$i]['name'] != $team['name']) {
                $matches[$j][0] = $team['name'];
                $matches[$j][1] = $teams[$i]['name'];
                $j++;
            }
        }
        array_shift($teams); // Erase the current team used
        if (count($teams) == 1) {
            break;
        }
    }

    $teams = dbGetTeamList($tournament_id);
    $dayMatches = array();
    $i = 0;
    $currentMatch = $matches[0];
    foreach ($matches as $match) {
        $oldMatch = $currentMatch;
        $currentMatch = $match;
        if ($currentMatch[0] == $oldMatch[0]) {
            $dayMatches[$i][0] = $currentMatch;
            $i++;
        }
        else {
            foreach ($dayMatches as $dayMatch) {
                //echo $dayMatch[0][0];
                //echo "<br>";
                //var_dump($dayMatch);
                //$dayMatch[0][0] == $currentMatch[0] || $dayMatch[0][1] == $currentMatch[0]
            }
        }
    }
}
