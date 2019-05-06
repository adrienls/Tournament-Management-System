<?php
require_once "./controller-Global.php";
require_once "../Model/Tournament.php";

if(isset($_GET['func'])) {
    if(isset($_GET['id'])){
        $_GET['func']($_GET['id']);
    }
    else {
        $_GET['func']();
    }
}

function createTournament() {
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
    $infoTeam= dbGetInfoTeam($team_id);

    $pathLogo= $infoTeam['path_logo'];

    if(file_exists($pathLogo)){
        unlink( $pathLogo ) ;
    }
    dbDeleteTeam($team_id);
}

function deleteTournament($id){
    $teams = dbGetTeamList($id);
    foreach ($teams as $team) {
        deleteTeamForTournament($team['id']);
    }
    dbDeleteTournament($id);
    redirect("../View/Admin/view-IndexAdmin.php?success=deleteTournament");
}

function testNumberMaxTeam($tournament_id){
    $nbTeamMax = dbGetNbTeamMax($tournament_id);
    $nbTeam = dbGetNbTeam($tournament_id);

    if($nbTeam<$nbTeamMax){
        return 0;
    }
    else{
        return 1;
    }
}

//Round Robin Tournament Algorithm taken from : https://phpro.org/examples/Create-Round-Robin-Using-PHP.html
function generateMatches($teams){

    if (count($teams)%2 != 0){
        array_push($teams,"exempt");
    }
    $away = array_splice($teams,(count($teams)/2));
    $home = $teams;
    $round = [];
    for ($i=0; $i < count($home)+count($away)-1; $i++) {
        for ($j=0; $j<count($home); $j++) {
            $round[$i][$j]["Home"]=$home[$j];
            $round[$i][$j]["Away"]=$away[$j];
        }
        if(count($home)+count($away)-1 > 2) {
            $s = array_splice($home,1,1);
            $slice = array_shift($s); // array to string conversion
            array_unshift($away,$slice);
            array_push($home, array_pop($away));
        }
    }
    return $round;
}

function generateDays($tournament_id) {
    $teamsList = dbGetTeamList($tournament_id);
    $teams = [];
    foreach ($teamsList as $team) {
        array_push($teams,$team['name']);
    }

    $nbTeams = count($teams);
    $nbDays = ($nbTeams % 2 == 0) ? $nbTeams-1 : $nbTeams;

    for ($i = 1; $i <= $nbDays; $i++) {
        dbInsertDay($tournament_id,$i);
    }
    $days = dbGetDayList($tournament_id);

    $matches = generateMatches($teams);
    foreach ($days as $day) {
        for ($j=0; $j<$nbTeams/2; $j++) {
            dbInsertPlanning($day['id'],$matches[$day['day_number']-1][$j]['Home'],$matches[$day['day_number']-1][$j]['Away']);
        }
    }

    redirect("../View/Admin/Tournament/view-IndexTournament.php?id=".$tournament_id ."&name=".$_GET['name']."&success=generate");
}


