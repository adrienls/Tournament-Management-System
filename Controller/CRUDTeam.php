<?php

require_once "GlobalFunctions.php";

if(isset($_GET['func'])) {
    if(isset($_GET['id'])){
        $_GET['func']($_GET['id']);
    }
    else {
        $_GET['func']();
    }
}

function createTeam($tournament_id) {

    //Connection to database
    $connection = connectDB();

    //Fields recovery
    $name = $_POST['name'];

    //Verification of all fields
    if(empty($name) || empty($_FILES['logo']['name'])){
        redirect("../View/Admin/newTeam.php?error=field_missing");
    }

    //Name verification
    $queryTeams = $connection->prepare("SELECT * FROM Team WHERE tournament_id='$tournament_id'");
    $queryTeams->execute();
    $dbTeams = $queryTeams->fetchAll();
    foreach ($dbTeams as $team) {
        if($name == $team['name']){
            redirect("../View/Admin/newTeam.php?error=name_used");
        }
    }

    //Logo path verification
    $file = $_FILES['logo']['tmp_name'];
    $fileDestination = '../Images/'.time().'.txt';
    $fileSize = $_FILES['logo']['size'];
    if($fileSize > 100000) {
        redirect("../View/Admin/newTeam.php?error=logo_invalid");
    }
    move_uploaded_file($file,$fileDestination);

    //VERIFICATION TAILLE + DIMENSIONS

    //Informations sending
    $insert = $connection->prepare("INSERT INTO Team (id, name, tournament_id, nb_visit, path_logo) VALUES (NULL, :name, :tournament_id, 0, :path_logo)");
    $insert->bindParam(':name', $name);
    $insert->bindParam(':tournament_id', $tournament_id);
    $insert->bindParam(':path_logo', $fileDestination);
    $insert->execute();
    redirect("../View/Admin/tournamentManagement.php?id=".$tournament_id."");
}

function deleteTeam($team_id) {

    $connection = connectDB();
    $queryIdTournament = $connection->prepare("SELECT tournament_id FROM Team WHERE id='$team_id'");
    $queryIdTournament->execute();
    $tournament_id = $queryIdTournament->fetchColumn();
    $delete = $connection->prepare("DELETE FROM Team WHERE id='$team_id'");
    $delete->execute();
    redirect("../View/Admin/tournamentManagement.php?id=".$tournament_id."&success=delete");
}