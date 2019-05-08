<?php
require_once "controller-Global.php";
require_once __DIR__."/../Model/Planning.php";

session_start();
if (!isset($_SESSION['username'])) {
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

function cmp($a, $b) {
    if ($a["score"] == $b["score"]) {
        //if the score of two teams is the same
        //the ranking is calculated based on goal difference
        $aGoals = $a["goalScored"] - $a["goalTaken"];
        $bGoals = $b["goalScored"] - $b["goalTaken"];
        if($aGoals == $bGoals){
            return 0;
        }
        return ($aGoals < $bGoals) ? 1 : -1;
    }//organize the ranking by descending order of each team's score, or goal difference
    return ($a["score"] < $b["score"]) ? 1 : -1;
}
function getRankingsTournament($id_tournament){
    $teamList = getTeamList($id_tournament);
    $ranking = array();
    foreach ($teamList as $team){
        $ranking[$team->getName()] = array(
            "score" => 0,
            "goalScored" => 0,
            "goalTaken" => 0,
        );
    }
    $dailyRanking = array();

    $dayPlanning = getDayPlanning($id_tournament);
    foreach ($dayPlanning as $match){
        if ($match["done"] == 0){
            break;
        }
        $teamA_name = $match["teamA_name"];
        $teamB_name = $match["teamB_name"];
        if ($match["teamA_nbGoal"] > $match["teamB_nbGoal"]){
            $ranking[$teamA_name]["score"] += 3;
        }
        else if ($match["teamA_nbGoal"] < $match["teamB_nbGoal"]){
            $ranking[$teamB_name]["score"] += 3;
        }
        else if($match["teamA_nbGoal"] == $match["teamB_nbGoal"]){
            $ranking[$teamA_name]["score"] += 1;
            $ranking[$teamB_name]["score"] += 1;
        }
        //team id ou team name? vote pour team name
        $ranking[$teamA_name]["goalScored"] += $match["teamA_nbGoal"];
        $ranking[$teamA_name]["goalTaken"] += $match["teamB_nbGoal"];
        $ranking[$teamB_name]["goalScored"] += $match["teamB_nbGoal"];
        $ranking[$teamB_name]["goalTaken"] += $match["teamA_nbGoal"];

        uasort($ranking, "cmp");
        $dailyRanking[$match["day_number"]] = $ranking;
    }
    var_dump($dailyRanking);
    return $dailyRanking;
}

//getRankingsTournament(1);