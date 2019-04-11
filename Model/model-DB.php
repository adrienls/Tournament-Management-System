<?php
/**
 * Created by PhpStorm.
 * User: arthu
 * Date: 11/04/2019
 * Time: 11:25
 */

//function connectDB($host="localhost", $dbName="Tournament-Management-System", $user="testUser", $password="testPassword"){
function connectDB($host="localhost", $dbName="Tournament-Management-System", $user="testUser", $password="testPassword"){
    $dsn = 'mysql:host='.$host.';dbname='.$dbName;
    try {
        $dbConnection = new PDO($dsn, $user, $password);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
    catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
        return NULL;
    }
}
function getUsernameList(){
    $connection = connectDB();
    //Teams recovery
    $userList = $connection->prepare("SELECT username FROM Admin");
    $userList->execute();
    $userList = $userList->fetchAll();

    $connection = NULL;
    return $userList;
}
function getAdminTable($login){
    $connection = connectDB();
    //Teams recovery
    $adminTable = $connection->prepare("SELECT * FROM Admin WHERE username='$login'");
    $adminTable->execute();
    $adminTable = $adminTable->fetch();

    $connection = NULL;
    return $adminTable;
}
function getAdminList(){
    $connection = connectDB();
    //Teams recovery
    $queryAdmins = $connection->prepare("SELECT * FROM Admin ");
    $queryAdmins->execute();
    $admins = $queryAdmins->fetchAll();

    $connection = NULL;
    return $admins;
}
function modelDeleteAdmin($id){
    $connection = connectDB();
    $delete = $connection->prepare("DELETE FROM Admin WHERE id='$id'");
    $delete->execute();

    $connection = NULL;
    redirect("../View/SuperAdmin/view-IndexSuperAdmin.php?success=delete");
}
function modelUpdateAdmin($username, $password, $id){
    $connection = connectDB();
    $insert = $connection->prepare("UPDATE Admin SET username='$username', password='$password' WHERE id='$id'");
    $insert->execute();

    $connection = NULL;
    redirect("../View/SuperAdmin/view-IndexSuperAdmin.php?success=update");
}
function modelUpdateAdminView($id){
    $connection = connectDB();

    $queryAdmins = $connection->prepare("SELECT * FROM Admin WHERE id='$id'");
    $queryAdmins->execute();
    $admin = $queryAdmins->fetch();

    $connection = NULL;
    return $admin;
}
function insertAdmin($username, $password_encrypted){
    $connection = connectDB();
    $insert = $connection->prepare("INSERT INTO Admin (id, username, password) VALUES (NULL, :username, :password)");
    $insert->bindParam(':username', $username);
    $insert->bindParam(':password', $password_encrypted);
    $insert->execute();
    $connection = NULL;
    redirect("../View/SuperAdmin/view-IndexSuperAdmin.php?success=new");
}


// start for tournament

function getTournamentList(){
    $connection = connectDB();
    //Teams recovery
    $queryTournaments = $connection->prepare("SELECT * FROM Tournament ");
    $queryTournaments->execute();
    $tournaments = $queryTournaments->fetchAll();

    $connection = NULL;
    return $tournaments;
}
function oldTournament($id){
    $connection = connectDB();

    $queryNbTeam = $connection->prepare("SELECT * FROM Team WHERE tournament_id='$id'");
    $queryNbTeam->execute();
    $oldNbTeam = $queryNbTeam->rowCount();

    $connection = NULL;
    return $oldNbTeam;
}
function modelUpdateTournament($tournament_name,$nb_team,$id){
    $connection = connectDB();
    $insert = $connection->prepare("UPDATE Tournament SET name='$tournament_name', nb_team='$nb_team' WHERE id='$id'");
    $insert->execute();
    $connection = NULL;
    redirect("../View/Admin/view-IndexAdmin.php?success=update");
}
function modelEditTournamentView($id){
    $connection = connectDB();

    $queryTournament = $connection->prepare("SELECT * FROM Tournament WHERE id='$id'");
    $queryTournament->execute();
    $tournament = $queryTournament->fetch();

    $connection=NULL;
    return $tournament;
}
function teamList($id){
    $connection = connectDB();

    $queryTeams = $connection->prepare("SELECT * FROM Team WHERE tournament_id='$id'");
    $queryTeams->execute();
    $teams = $queryTeams->fetchAll();

    $connection=NULL;
    return $teams;
}
function modelDeleteTournament($id){
    $connection = connectDB();

    $delete = $connection->prepare("DELETE FROM Tournament WHERE id='$id'");
    $delete->execute();

    $connection=NULL;
    redirect("../View/Admin/view-IndexAdmin.php?success=delete");
}
function modelInfoTeam($team_id){
    $connection = connectDB();
    $queryIdPathTournament = $connection->prepare("SELECT tournament_id, path_logo FROM Team WHERE id='$team_id'");
    $queryIdPathTournament->execute();
    $infoTeam= $queryIdPathTournament->fetch();
    $connection=NULL;
    return $infoTeam;
}
function modelDeleteTeam($team_id){
    $connection=connectDB();
    $delete = $connection->prepare("DELETE FROM Team WHERE id='$team_id'");
    $delete->execute();
}