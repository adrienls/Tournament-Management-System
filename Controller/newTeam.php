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
    If( isset($_FILES['nomFichier']) && !empty($_FILES['nomFichier']['name'])) {
        $leFichierInit = $_FILES['nomFichier']['name'];
        $leFichier = $_FILES['nomFichier']['tmp_name'];
        $destFichier = 'tmp/'.time().'.txt';
        $leFichierTaille = $_FILES['nomFichier']['size'];
        $leFichierType = $_FILES['nomFichier']['type'];

        move_uploaded_file( $leFichier,$destFichier );
        echo "<br><br><br>Le fichier ".$leFichierInit." a été enregistré sous ".$destFichier." et est un fichier du type ".$leFichierType." et a une taille de : ".$leFichierTaille."octets<br>";
    }
    else {
        header('Location: TP5.php?fail=no_file');
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