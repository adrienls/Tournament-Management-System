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

function createTournament() {
    $tournamentName = $_POST['tournamentName'];
    $nbTeam = $_POST['nbTeam'];

    if(empty($tournamentName) || $nbTeam <= 0){
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
    require_once "controller-Days.php";

    $tournament_name = $_POST['tournament_name'];
    $nb_team = $_POST['nb_team'];

    if(empty($tournament_name) || $nb_team <= 0){
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=field_missing");
    }

    $oldNbTeam = getNbTeamMax($id);
    $currentNbTeamCreated = getNbTeam($id);
    //Verification of the number of teams
    if($nb_team < 0) {
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=number_invalid");
    }
    if(isGeneratedDays($id) && $nb_team != $oldNbTeam){
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=days_already_generated");
    }
    if($nb_team < $currentNbTeamCreated) {
        redirect("../View/Admin/Tournament/view-UpdateTournament.php?id=".$id ."&error=teams_already_created");
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

    $days = getDayList($id);
    foreach ($days as $day) {
        $dayId = $day->getId();
        $matches = getMatchesList($dayId);
        foreach ($matches as $match) {
            $match->deletePlanning($match->getId());
        }
        $day->deleteDay($dayId);
    }

    $tournament = new Tournament();
    $tournament->deleteTournament($id);
    redirect("../View/Admin/view-IndexAdmin.php?success=delete");
}

function testNumberMaxTeam($tournament_id){
    $nbTeamMax = getNbTeamMax($tournament_id);
    $nbTeam = getNbTeam($tournament_id);
    return ($nbTeam<$nbTeamMax);
}

function export() {
    require_once "controller-Planning.php";
    require('../fpdf/fpdf.php');

    $rankings = getRankingsTournament($_GET['id']);
    $ranking = array_pop($rankings);

    $largeur=38;
    $i=0;
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell($largeur-15,20,"Ranking",1,0,"C");
    $pdf->Cell($largeur,20,"Name",1,0,"C");
    $pdf->Cell($largeur,20,"Score",1,0,"C");
    $pdf->Cell($largeur,20,"GoalScored",1,0,"C");
    $pdf->Cell($largeur,20,"GoalTaken",1,1,"C");

    foreach ($ranking as $name => $team) {
        $i=$i+1;
        $pdf->Cell($largeur-15,20,$i,1,0,"C");
        $pdf->Cell($largeur,20,$name,1,0,"C");
        $pdf->Cell($largeur,20,$team['score'],1,0,"C");
        $pdf->Cell($largeur,20,$team['goalScored'],1,0,"C");
        $pdf->Cell($largeur,20,$team['goalTaken'],1,1,"C");
    }
    $pdf->Output();
}

