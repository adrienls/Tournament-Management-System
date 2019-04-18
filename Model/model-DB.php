<?php
/**
 * Created by PhpStorm.
 * User: arthu
 * Date: 11/04/2019
 * Time: 11:25
 */

/*
 * CONNECT
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
/*
 * SELECT
 */
function dbGetUsernameList(){
    $connection = connectDB();
    //Teams recovery
    $userList = $connection->prepare("SELECT username FROM Admin");
    $userList->execute();
    $userList = $userList->fetchAll();
    $connection = NULL;
    return $userList;
}
function dbGetAdminTable($login){
    $connection = connectDB();
    //Teams recovery
    $adminTable = $connection->prepare("SELECT * FROM Admin WHERE username='$login'");
    $adminTable->execute();
    $adminTable = $adminTable->fetch();
    $connection = NULL;
    return $adminTable;
}
function dbGetAdminList(){
    $connection = connectDB();
    //Teams recovery
    $queryAdmins = $connection->prepare("SELECT * FROM Admin ");
    $queryAdmins->execute();
    $admins = $queryAdmins->fetchAll();
    $connection = NULL;
    return $admins;
}
function dbUpdateAdminView($id){
    $connection = connectDB();
    $queryAdmins = $connection->prepare("SELECT * FROM Admin WHERE id='$id'");
    $queryAdmins->execute();
    $admin = $queryAdmins->fetch();
    $connection = NULL;
    return $admin;
}
function dbGetTournamentList(){
    $connection = connectDB();
    //Teams recovery
    $queryTournaments = $connection->prepare("SELECT * FROM Tournament ");
    $queryTournaments->execute();
    $tournaments = $queryTournaments->fetchAll();
    $connection = NULL;
    return $tournaments;
}
function dbGetNumberTournament($id){
    $connection = connectDB();
    $queryNbTeam = $connection->prepare("SELECT * FROM Team WHERE tournament_id='$id'");
    $queryNbTeam->execute();
    $oldNbTeam = $queryNbTeam->rowCount();
    $connection = NULL;
    return $oldNbTeam;
}
function dbGetNbTeamMax($tournament_id){
    $connection = connectDB();
    $queryNbTeamMax = $connection->prepare("SELECT nb_team FROM Tournament WHERE id='$tournament_id'");
    $queryNbTeamMax->execute();
    $nbTeamMax = $queryNbTeamMax->fetchColumn();
    $connection = NULL;
    return $nbTeamMax;
}
function dbEditTournamentView($id){
    $connection = connectDB();
    $queryTournament = $connection->prepare("SELECT * FROM Tournament WHERE id='$id'");
    $queryTournament->execute();
    $tournament = $queryTournament->fetch();
    $connection = NULL;
    return $tournament;
}
function dbGetTeamList($id){
    $connection = connectDB();
    $queryTeams = $connection->prepare("SELECT * FROM Team WHERE tournament_id='$id'");
    $queryTeams->execute();
    $teams = $queryTeams->fetchAll();
    $connection = NULL;
    return $teams;
}
function dbGetSpecificTeam($id_team){
    $connection = connectDB();
    $queryInfos = $connection->prepare("SELECT * FROM Team WHERE id='$id_team'");
    $queryInfos->execute();
    $info = $queryInfos->fetch();
    $connection = NULL;
    return $info;
}
function dbGetInfoTeam($team_id){
    $connection = connectDB();
    $queryIdPathTournament = $connection->prepare("SELECT tournament_id, path_logo FROM Team WHERE id='$team_id'");
    $queryIdPathTournament->execute();
    $infoTeam = $queryIdPathTournament->fetch();
    $connection = NULL;
    return $infoTeam;
}
function dbGetCorrespondingLogoAndID($id){
    $connection = connectDB();
    $queryIdPathTournament = $connection->prepare("SELECT tournament_id, path_logo FROM Team WHERE id='$id'");
    $queryIdPathTournament->execute();
    $infoTeam = $queryIdPathTournament->fetch();
    $connection = NULL;
    return $infoTeam;
}
/*
 * INSERT
 */
function insertAdmin($username, $password_encrypted){
    $connection = connectDB();
    $insert = $connection->prepare("INSERT INTO Admin (id, username, password) VALUES (NULL, :username, :password)");
    $insert->bindParam(':username', $username);
    $insert->bindParam(':password', $password_encrypted);
    $insert->execute();
    $connection = NULL;
}
function insertTeam($name, $tournament_id, $fileDestination){
    $connection = connectDB();
    $insert = $connection->prepare("INSERT INTO Team (id, name, tournament_id, nb_visit, path_logo) VALUES (NULL, :name, :tournament_id, 0, :path_logo)");
    $insert->bindParam(':name', $name);
    $insert->bindParam(':tournament_id', $tournament_id);
    $insert->bindParam(':path_logo', $fileDestination);
    $insert->execute();
    $connection = NULL;
}
function insertTournament($tournamentName, $nbTeam){
    $connection = connectDB();
    $insert = $connection->prepare("INSERT INTO Tournament (id, name, nb_team) VALUES (NULL, :name, :nb_team)");
    $insert->bindParam(':name', $tournamentName);
    $insert->bindParam(':nb_team', $nbTeam);
    $insert->execute();
    $connection = NULL;
}
/*
 * UPDATE
 */
function dbUpdateAdmin($username, $password, $id){
    $connection = connectDB();
    $insert = $connection->prepare("UPDATE Admin SET username='$username', password='$password' WHERE id='$id'");
    $insert->execute();
    $connection = NULL;
}
function dbUpdateTournament($tournament_name, $nb_team, $id){
    $connection = connectDB();
    $insert = $connection->prepare("UPDATE Tournament SET name='$tournament_name', nb_team='$nb_team' WHERE id='$id'");
    $insert->execute();
    $connection = NULL;
}
function dbUpdateTeam($team_name, $fileDestination, $id_team){
    $connection = connectDB();
    $insert = $connection->prepare("UPDATE Team SET name='$team_name', path_logo='$fileDestination' WHERE id='$id_team'");
    $insert->execute();
    $connection = NULL;
}
/*
 * DELETE
 */
function dbDeleteAdmin($id){
    $connection = connectDB();
    $delete = $connection->prepare("DELETE FROM Admin WHERE id='$id'");
    $delete->execute();
    $connection = NULL;
}
function dbDeleteTournament($id){
    $connection = connectDB();
    $delete = $connection->prepare("DELETE FROM Tournament WHERE id='$id'");
    $delete->execute();
    $connection=NULL;
}
function dbDeleteTeam($team_id){
    $connection=connectDB();
    $delete = $connection->prepare("DELETE FROM Team WHERE id='$team_id'");
    $delete->execute();
    $connection=NULL;
}