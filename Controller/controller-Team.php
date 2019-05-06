<?php
require_once "controller-Global.php";
require_once __DIR__."/../Model/Team.php";

if(isset($_GET['func'])) {
    if(isset($_GET['id'])){
        $_GET['func']($_GET['id']);
    }
    else {
        $_GET['func']();
    }
}

function createTeam($tournament_id) {
    require_once "../Model/Database.php";
    //Fields recovery
    $name = $_POST['name'];

    //Verification of all fields
    if(empty($name) || empty($_FILES['logo']['name'])){
        redirect("../View/Admin/Team/view-CreateTeam.php?id=".$tournament_id."&name=".$_GET['name']."&error=field_missing");
    }

    //Name verification
    $dbTeams = getTeamList($tournament_id);
    foreach ($dbTeams as $team) {
        if($name == $team->getName()){
            redirect("../View/Admin/Team/view-CreateTeam.php?id=".$tournament_id."&name=".$_GET['name']."&error=name_used");
        }
    }

    //Logo path verification
    $file = $_FILES['logo']['tmp_name'];
    $nameNewFile=$_FILES['logo']['name'];
    $extension=strrchr($nameNewFile,".");
    $fileDestination = '../Images/'.time().$extension;
    $fileSize = $_FILES['logo']['size'];
    if($fileSize > 100000) {
        redirect("../View/Admin/Team/view-CreateTeam.php?id=".$tournament_id."&name=".$_GET['name']."&error=logo_invalid");
    }
    move_uploaded_file($file, $fileDestination);

    //Information sending
    $team = new Team();
    $team->insertTeam($name, $tournament_id, $fileDestination);
    redirect("../View/Admin/Tournament/view-IndexTournament.php?id=".$tournament_id."&name=".$_GET['name']."");
}

function deleteTeam($team_id) {
    require_once "../Model/Team.php";
    $infoTeam = getInfoTeam($team_id);
    $tournament_id = $infoTeam->getTournamentId();
    $path_logo = $infoTeam->getPathLogo();

    if(file_exists($path_logo)){
        unlink( $path_logo ) ;
    }
    $team = new Team();
    $team->deleteTeam($team_id);
    redirect("../View/Admin/Tournament/view-IndexTournament.php?id=".$tournament_id."&name=".$_GET['name']."&success=delete");
}

function editTeam($id_team){
    require_once "../Model/Database.php";

    $team_name = $_POST['name'];

    if(empty($team_name)){
        redirect("../View/Admin/Team/view-UpdateTeam.php?id=".$id_team."&name=".$_GET['name']."&error=need_name");
    }

    //Verification of the name of team's uniqueness
    $infoTeam = getTeamById($id_team);
    $id_tournament = $infoTeam->getTournamentId();
    $pathLogo= $infoTeam->getPathLogo();

    $dbTeams = getTeamList($id_tournament);
    foreach ($dbTeams as $team) {
        if($team_name == $team->getName()){
            redirect("../View/Admin/Team/view-UpdateTeam.php?id=".$id_team."&name=".$_GET['name']."&error=name_used");
        }
    }

    $file = $_FILES['logo']['tmp_name'];
    $nameNewFile=$_FILES['logo']['name'];
    $extension=strrchr($nameNewFile,".");
    $fileDestination = '../Images/'.time().$extension;
    $fileSize = $_FILES['logo']['size'];
    if($fileSize > 100000) {
        redirect("../View/Admin/Team/view-CreateTeam.php?id=".$id_team."&name=".$_GET['name']."&error=logo_invalid");
    }
    if(file_exists($pathLogo))
        unlink($pathLogo);
    move_uploaded_file($file,$fileDestination);

    //Informations sending
    $team = new Team();
    $team->updateTeam($team_name,$fileDestination,$id_team);
    redirect("../View/Admin/Tournament/view-IndexTournament.php?id=".$id_tournament."&name=".$_GET['name']."&success=update");

}
