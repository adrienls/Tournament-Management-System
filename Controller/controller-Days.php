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


function playDay($tournament_id){
    $days = getDayList($tournament_id);
    $actualDay=0;
    $actualDayId=0;
    $oldday=1;
    foreach ($days as $day){
        $dayDone=$day->getDone();
        $dayId = $day->getId();
        $dayNumber = $day->getDayNumber();
        if (!$dayDone){
            if ($oldday>=1){
                $actualDayId=$dayId;
                $actualDay=$dayNumber;
                $oldday=0;
            }
        }
        else {
            $oldday=$dayNumber;
        }
    }
//    echo $actualDayId;
    $plannings=dbGetPlanning($actualDayId);
    foreach ($plannings as $planning){
        $planningId=$planning->getId();
        echo "on rentre la";
        echo $planningId;
        dbUpdateGoal($planningId);
    }
    $day = new Day();
    $day->dbChangeDay($actualDayId);
    //redirect("../View/Admin/Tournament/view-IndexTournament.php?id=".$tournament_id ."&name=".$_GET['name']."&success=play");

}
function goal(){
    $proba=rand(0,99);
    if($proba<20){
        $goal=0;
    }
    elseif($proba<40){
        $goal=1;
    }
    elseif($proba<60){
        $goal=2;
    }
    elseif($proba<75){
        $goal=3;
    }
    elseif($proba<85){
        $goal=4;
    }
    elseif($proba<90){
        $goal=5;
    }
    elseif($proba<95){
        $goal=6;
    }
    elseif($proba<96.6){
        $goal=7;
    }
    elseif($proba<98.4){
        $goal=8;
    }
    elseif($proba<100){
        $goal=9;
        /*$proba2=rand(0,2);
        if($proba2==0){
            $goal=7;
        }
        if($proba2==1){
            $goal=8;
        }
        if($proba2==2){
            $goal=9;
        }*/
    }
return $goal;
}

/*
function dbGetDay($tournament_id){
    $connection = connectDB();
    $day = $connection->prepare("SELECT * FROM Day WHERE tournament_id='$tournament_id'");
    $day->execute();
    $connection = NULL;
    return $day;
}
function dbGetPlanning($day_id){
    $connection = connectDB();
    $planning = $connection->prepare("SELECT * FROM Planning WHERE day_id='$day_id'");
    $planning->execute();
    $connection = NULL;
    return $planning;
function dbUpdateGoal($id){
    $goal1=goal();
    $goal2=goal();
    $connection=connectDB();
    $update = $connection->prepare("UPDATE Planning SET teamA_nbGoal=$goal1,teamB_nbGoal=$goal2 WHERE id='$id'");
    $update->execute();
    $connection = NULL;
}
function dbChangeDay($id){
    $connection=connectDB();
    $update = $connection->prepare("UPDATE Day SET done=1 WHERE id='$id'");
    $update->execute();
}
*/