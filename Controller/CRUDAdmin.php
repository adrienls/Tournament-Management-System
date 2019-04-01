<?php

require_once "GlobalFunctions.php";

if(isset($_GET['func'])) {
    $_GET['func']();
}

function createAdmin() {
    //Connection to database
    $connection = connectDB();

    redirect("../View/Admin/newAdmin.php?error=field_missing");


    //Fields recovery
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Verification of all fields
    if(empty($username) || empty($password)) {
        redirect("../View/Admin/newAdmin.php?error=field_missing");
    }

    //Username verification
    $queryAdmins = $connection->prepare("SELECT * FROM Admin");
    $queryAdmins->execute();
    $admins = $queryAdmins->fetchAll();
    foreach ($admins as $admin) {
        if($username == $admin['username']){
            redirect("../View/Admin/newAdmin.php?error=name_used");
        }
    }

    //Informations sending
    $password_encrypted = password_hash($password, PASSWORD_DEFAULT);
    $insert = $connection->prepare("INSERT INTO Admin (id, username, password) VALUES (NULL, :username, :password)");
    $insert->bindParam(':username', $username);
    $insert->bindParam(':password', $password_encrypted);
    $insert->execute();
    redirect("../View/Admin/superAdmin.php");
}

function updateAdmin(){

}

function deleteAdmin(){

}

function viewTournament(){

    $connection = connectDB();

    //Recuperation des etudiants
    $id = $_SESSION['id'];
    $querryTournaments = $connection->prepare("SELECT * FROM Tournament ");
    $querryTournaments->execute();
    $tournaments = $querryTournaments->fetchAll();

    //Affichage
    echo "<table><tr><th>Id</th><th>Name</th><th>Number of team</th></tr>";
    foreach($tournaments as $tournament) {
        echo "<tr><td>".$tournament['id']."</td><td>".$tournament['name']."</td><td>".$tournament['nb_team']."</td><td><a href=\"editTournament.php?id=".$tournament['id']."\">Edit</a></td><td><a href=\"CRUDAdmin.php?func=deleteEtudiant&&id=".$tournament['id']."\">Delete</a></td></tr>";
    }
    echo "</table>";

    $conn = NULL;
}
