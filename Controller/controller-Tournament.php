<?php
require_once "controller-Global.php";
require_once __DIR__."/../Model/Day.php";
require_once __DIR__."/../Model/Team.php";
require_once __DIR__."/../Model/Planning.php";
require_once __DIR__."/../Model/Tournament.php";

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
    $dbTournament = getTournamentList();
    foreach ($dbTournament as $tournament) {
        if($tournamentName == $tournament->getName()){
            redirect("../View/Admin/Tournament/view-CreateTournament.php?error=name_used");
        }
    }

    //Informations sending
    $tournament = new Tournament();
    $tournament->insertTournament($tournamentName, $nbTeam);
    redirect("../View/Admin/view-IndexAdmin.php?success=new");
}

function editTournament($id){
    $tournament_name = $_POST['tournament_name'];
    $nb_team = $_POST['nb_team'];

    if(empty($tournament_name) || empty($nb_team)){
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=field_missing");
    }

    $oldNbTeam = getNbTeamMax($id);

    //Verification of the number of teams
    if($nb_team < 0) {
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=number_invalid");
    }
    if($nb_team<$oldNbTeam) {
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=number_use");
    }

    //Informations sending
    $tournament = new Tournament();
    $tournament->updateTournament($tournament_name,$nb_team,$id);
    redirect("../View/Admin/view-IndexAdmin.php?success=update");
}

function deleteTeamForTournament($team_id) {
    $infoTeam = getInfoTeam($team_id);

    $pathLogo= $infoTeam->getPathLogo();

    if(file_exists($pathLogo)){
        unlink( $pathLogo ) ;
    }
    $team = new Team();
    $team->deleteTeam($team_id);
}

function deleteTournament($id){
    $teams = getTeamList($id);
    foreach ($teams as $team) {
        deleteTeamForTournament($team->getId());
    }
    $tournament = new Tournament();
    $tournament->deleteTournament($id);
    redirect("../View/Admin/view-IndexAdmin.php?success=deleteTournament");
}

function testNumberMaxTeam($tournament_id){
    $nbTeamMax = getNbTeamMax($tournament_id);
    $nbTeam = getNbTeam($tournament_id);

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
    $teamsList = getTeamList($tournament_id);
    $teams = [];
    foreach ($teamsList as $team) {
        array_push($teams,$team->getName());
    }

    $nbTeams = count($teams);
    $nbDays = ($nbTeams % 2 == 0) ? $nbTeams-1 : $nbTeams;

    for ($i = 1; $i <= $nbDays; $i++) {
        $day = new Day();
        $day->insertDay($tournament_id,$i);
    }
    $days = getDayList($tournament_id);

    $matches = generateMatches($teams);
    foreach ($days as $day) {
        for ($j=0; $j<$nbTeams/2; $j++) {
            $dayNumber = $day->getDayNumber();
            $dayId = $day->getId();
            $planning = new Planning();
            $planning->insertPlanning($dayId,$matches[$dayNumber-1][$j]['Home'],$matches[$dayNumber-1][$j]['Away']);
        }
    }

    redirect("../View/Admin/Tournament/view-IndexTournament.php?id=".$tournament_id ."&name=".$_GET['name']."&success=generate");
}


