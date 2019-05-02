<?php
require_once "controller-GlobalFunctions.php";

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
    $dbTeams = dbGetTeamList($tournament_id);
    foreach ($dbTeams as $team) {
        if($name == $team['name']){
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
    dbInsertTeam($name, $tournament_id, $fileDestination);
    redirect("../View/Admin/Tournament/view-IndexTournament.php?id=".$tournament_id."&name=".$_GET['name']."");
}

function deleteTeam($team_id) {
    require_once "../Model/Database.php";
    $infoTeam = dbGetInfoTeam($team_id);
    $tournament_id = $infoTeam['tournament_id'];
    $path_logo = $infoTeam['path_logo'];

    if(file_exists($path_logo)){
        unlink( $path_logo ) ;
    }
    dbDeleteTeam($team_id);
    redirect("../View/Admin/Tournament/view-IndexTournament.php?id=".$tournament_id."&name=".$_GET['name']."&success=delete");
}

function editTeam($id_team){
    require_once "../Model/Database.php";

    $team_name = $_POST['name'];

    if(empty($team_name)){
        redirect("../View/Admin/Team/view-UpdateTeam.php?id=".$id_team."&name=".$_GET['name']."&error=need_name");
    }

    //Verification of the name of team's uniqueness
    $infoTeam = dbGetTeamById($id_team);
    $id_tournament = $infoTeam['tournament_id'];
    $pathLogo= $infoTeam['path_logo'];

    $dbTeams = dbGetTeamList($id_tournament);
    foreach ($dbTeams as $team) {
        if($team_name == $team['name']){
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
    dbUpdateTeam($team_name,$fileDestination,$id_team);
    redirect("../View/Admin/Tournament/view-IndexTournament.php?id=".$id_tournament."&name=".$_GET['name']."&success=update");

}

function editTeamView($id_team){
    require_once "../Model/Database.php";
    $info = dbGetTeamById($id_team);

    echo "Name : <input type='text' name='name' value='".$info['name']."'/>
    <br>
    Logo : <input type='file' name='logo' size='100000'/>
    <br>";

}