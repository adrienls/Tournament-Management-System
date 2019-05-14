<?php
require_once "controller-Global.php";
require_once __DIR__."/../Model/Day.php";
require_once __DIR__."/../Model/Team.php";
require_once __DIR__."/../Model/Planning.php";
require_once __DIR__."/../Model/Tournament.php";


if (!isIdentified()) {
    redirect("../View/index.php?error=access_denied");
}

if(isset($_GET['func'])) {
    if(isset($_GET['id'])){
        $_GET['func']($_GET['id']);
    }
    else {
        $_GET['func']();
    }
}

//Round Robin Tournament Algorithm
function generateMatches($teams) {

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

function isGeneratedDays($tournament_id) {
    $days = getDayList($tournament_id);
    return (count($days) != 0);
}

function playDay($tournament_id) {

    if(getNbPlayedDays($_GET['id']) == getNbDays($_GET['id'])) {
        redirect("../View/Admin/Tournament/view-IndexTournament.php?id=".$tournament_id."&name=".$_GET['name']."&error=all_days_played");
    }
    $days = getDayList($tournament_id);
    //$actualDay = 0;
    $actualDayId = 0;
    $oldDay = 1;
    foreach ($days as $day) {
        $dayDone = $day->getDone();
        $dayId = $day->getId();
        $dayNumber = $day->getDayNumber();
        if (!$dayDone) {
            if ($oldDay >= 1) {
                $actualDayId = $dayId;
                //$actualDay = $dayNumber;
                $oldDay = 0;
            }
        }
        else {
            $oldDay = $dayNumber;
        }
    }

    $matches = getMatchesList($actualDayId);
    foreach ($matches as $match){
        if ($match->getTeamAName() != "exempt" && $match->getTeamBName() != "exempt") {
            $teamA_nbGoal = goal();
            $teamB_nbGoal = goal();
            $match->updateMatchGoal($match->getId(),$teamA_nbGoal,$teamB_nbGoal);
        }
    }
    $day = getDayById($actualDayId);
    $day->updateDayPlayed($actualDayId);
    redirect("../View/Admin/Tournament/view-IndexTournament.php?id=".$tournament_id."&name=".$_GET['name']."&success=play&day_number=".$day->getDayNumber());

}

function goal() {
    $probability = rand(0,99);
    if ($probability < 20) { $goal = 0; }
    elseif ($probability < 40) { $goal = 1; }
    elseif ($probability < 60) { $goal = 2; }
    elseif ($probability < 75) { $goal = 3; }
    elseif ($probability < 85) { $goal = 4; }
    elseif ($probability < 90) { $goal = 5; }
    elseif ($probability < 95) { $goal = 6; }
    //elseif ($probability < 96.6) { $goal = 7; }
    //elseif ($probability < 98.4) { $goal = 8; }
    //elseif ($probability < 100) { $goal = 9; }
    elseif ($probability < 100) {
        $probability2 = rand(0,2);
        if ($probability2 == 0) { $goal = 7; }
        if ($probability2 == 1) { $goal = 8; }
        if ($probability2 == 2) { $goal = 9; }
    }
    return $goal;
}

function isPlayedDays($tournament_id) {
    $playedDays = getNbPlayedDays($tournament_id);
    return ($playedDays != 0);
}
