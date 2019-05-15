<?php
require_once "controller-Global.php";
require_once __DIR__."/../Model/Planning.php";
require_once __DIR__."/../Model/Team.php";

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
        if ($teamA_name != "exempt" && $teamB_name != "exempt") {
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
            $ranking[$teamA_name]["goalScored"] += $match["teamA_nbGoal"];
            $ranking[$teamA_name]["goalTaken"] += $match["teamB_nbGoal"];
            $ranking[$teamB_name]["goalScored"] += $match["teamB_nbGoal"];
            $ranking[$teamB_name]["goalTaken"] += $match["teamA_nbGoal"];

            uasort($ranking, "cmp");
            $dailyRanking[$match["day_number"]] = $ranking;
        }
    }
    return $dailyRanking;
}
function exportRanking() {
    require_once "controller-Planning.php";
    require('../fpdf/fpdf.php');

    $rankings = getRankingsTournament($_GET['id']);
    $ranking = array_pop($rankings);

    $largeur=38;
    $hauteur=20;
    $i=0;
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell($largeur-15,$hauteur,"Ranking",1,0,"C");
    $pdf->Cell($largeur,$hauteur,"Name",1,0,"C");
    $pdf->Cell($largeur,$hauteur,"Score",1,0,"C");
    $pdf->Cell($largeur,$hauteur,"GoalScored",1,0,"C");
    $pdf->Cell($largeur,$hauteur,"GoalTaken",1,1,"C");

    foreach ($ranking as $name => $team) {
        $i=$i+1;
        $pdf->Cell($largeur-15,$hauteur,$i,1,0,"C");
        $pdf->Cell($largeur,$hauteur,$name,1,0,"C");
        $pdf->Cell($largeur,$hauteur,$team['score'],1,0,"C");
        $pdf->Cell($largeur,$hauteur,$team['goalScored'],1,0,"C");
        $pdf->Cell($largeur,$hauteur,$team['goalTaken'],1,1,"C");
    }
    $pdf->Output();
}
function exportPlanning() {
    require_once "controller-Planning.php";
    require('../fpdf/fpdf.php');

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);

    $daysPlanning=getDayPlanning($_GET['id']);
    $largeur=50;
    $hauteur=20;
    $pdf->Cell($largeur,$hauteur,"Team A Name",1,0,"C");
    $pdf->Cell($largeur/2,$hauteur,"Goal A",1,0,"C");
    $pdf->Cell($largeur/2,$hauteur,"Goal B",1,0,"C");
    $pdf->Cell($largeur,$hauteur,"Team B Name",1,0,"C");
    $pdf->Cell($largeur/2,$hauteur,"Day",1,1,"C");

    foreach ($daysPlanning as $dayPlanning){
        $pdf->Cell($largeur,$hauteur,$dayPlanning['teamA_name'],1,0,"C");
        $pdf->Cell($largeur/2,$hauteur,$dayPlanning['teamA_nbGoal'],1,0,"C");
        $pdf->Cell($largeur/2,$hauteur,$dayPlanning['teamB_nbGoal'],1,0,"C");
        $pdf->Cell($largeur,$hauteur,$dayPlanning['teamB_name'],1,0,"C");
        $pdf->Cell($largeur/2,$hauteur,$dayPlanning['day_number'],1,1,"C");

    }
    $pdf->Output();

}
