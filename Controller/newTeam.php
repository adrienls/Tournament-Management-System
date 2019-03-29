<?php

require_once "redirect.php";
require_once "../Model/dbConfig.php";

if(isset($_GET['func'])) {
    if(isset($_GET['id'])){
        $_GET['func']($_GET['id']);
    }
    else {
        $_GET['func']();
    }
}

function newTeam($tournament_id) {

    //Connection do database
    $dbConfig = new DbConfig();
    $dbConfig->connectDB();
    $connection = $dbConfig->getDbConnexion();

    //Fields recovery
    $name = $_POST['name'];
    $logo = $_POST['logo'];

    //Verification of all fields
    if(empty($name) || empty($logo)){
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
    if(!filter_var($logo,FILTER_VALIDATE_URL)){
        redirect("../View/Admin/newTeam.php?error=logo_invalid");
    }

    //VERIFICATION TAILLE + DIMENSIONS

    //Informations sending
    $insert = $connection->prepare("INSERT INTO Team (id, name, tournament_id, nb_visit, path_logo) VALUES (NULL, :name, :tournament_id, 0, :path_logo)");
    $insert->bindParam(':name', $name);
    $insert->bindParam(':tournament_id', $tournament_id);
    $insert->bindParam(':path_logo', $logo);
    $insert->execute();
    redirect("../View/Admin/adminView.php");
}