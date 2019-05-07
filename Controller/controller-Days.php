<?php
require_once "controller-Global.php";
require_once __DIR__."/../Model/Team.php";
require_once __DIR__."/../Model/Day.php";
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