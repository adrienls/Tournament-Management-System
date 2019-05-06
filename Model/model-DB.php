<?php
/**
 * Created by PhpStorm.
 * User: arthu
 * Date: 11/04/2019
 * Time: 11:25
 */

//function connectDB($host="localhost", $dbName="Tournament-Management-System", $user="adrien", $password="password"){
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

//Admin
function dbGetUserList(){
    $connection = connectDB();
    $userList = $connection->prepare("SELECT username FROM Admin");
    $userList->execute();
    $userList = $userList->fetchAll();
    $connection = NULL;
    return $userList;
}
function dbGetAdminTable($login){
    $connection = connectDB();
    $adminTable = $connection->prepare("SELECT * FROM Admin WHERE username='$login'");
    $adminTable->execute();
    $adminTable = $adminTable->fetch();
    $connection = NULL;
    return $adminTable;
}
function dbGetAdminList(){
    $connection = connectDB();
    $adminList = $connection->prepare("SELECT * FROM Admin ");
    $adminList->execute();
    $adminList = $adminList->fetchAll();
    $connection = NULL;
    return $adminList;
}
function dbGetAdminById($id){
    $connection = connectDB();
    $adminById = $connection->prepare("SELECT * FROM Admin WHERE id='$id'");
    $adminById->execute();
    $adminById = $adminById->fetch();
    $connection = NULL;
    return $adminById;
}
function dbInsertAdmin($username, $password_encrypted){
    $connection = connectDB();
    $insertAdmin = $connection->prepare("INSERT INTO Admin (id, username, password) VALUES (NULL, :username, :password)");
    $insertAdmin->bindParam(':username', $username);
    $insertAdmin->bindParam(':password', $password_encrypted);
    $insertAdmin->execute();
    $connection = NULL;
}
function dbUpdateAdmin($username, $password, $id){
    $connection = connectDB();
    $updateAdmin = $connection->prepare("UPDATE Admin SET username='$username', password='$password' WHERE id='$id'");
    $updateAdmin->execute();
    $connection = NULL;
}
function dbDeleteAdmin($id){
    $connection = connectDB();
    $delete = $connection->prepare("DELETE FROM Admin WHERE id='$id'");
    $delete->execute();

    $connection = NULL;
    redirect("../View/SuperAdmin/view-IndexSuperAdmin.php?success=delete");
}

//Tournament
function dbGetTournamentList(){
    $connection = connectDB();
    $tournamentList = $connection->prepare("SELECT * FROM Tournament ");
    $tournamentList->execute();
    $tournamentList = $tournamentList->fetchAll();
    $connection = NULL;
    return $tournamentList;
}
function dbGetTournamentById($id){
    $connection = connectDB();
    $tournamentById = $connection->prepare("SELECT * FROM Tournament WHERE id='$id'");
    $tournamentById->execute();
    $tournamentById = $tournamentById->fetch();
    $connection=NULL;
    return $tournamentById;
}
function dbGetNbTeamMax($tournament_id){
    $connection = connectDB();
    $nbTeamMax = $connection->prepare("SELECT nb_team FROM Tournament WHERE id='$tournament_id'");
    $nbTeamMax->execute();
    $nbTeamMax = $nbTeamMax->fetchColumn();
    $connection = NULL;
    return $nbTeamMax;
}
function dbInsertTournament($tournamentName, $nbTeam){
    $connection = connectDB();
    $insertTournament = $connection->prepare("INSERT INTO Tournament (id, name, nb_team) VALUES (NULL, :name, :nb_team)");
    $insertTournament->bindParam(':name', $tournamentName);
    $insertTournament->bindParam(':nb_team', $nbTeam);
    $insertTournament->execute();
    $connection=NULL;
}
function dbUpdateTournament($tournament_name, $nb_team, $id){
    $connection = connectDB();
    $updateTournament = $connection->prepare("UPDATE Tournament SET name='$tournament_name', nb_team='$nb_team' WHERE id='$id'");
    $updateTournament->execute();
    $connection = NULL;
}
function dbDeleteTournament($id){
    $connection = connectDB();
    $deleteTournament = $connection->prepare("DELETE FROM Tournament WHERE id='$id'");
    $deleteTournament->execute();
    $connection=NULL;
}

//Team Table
function dbGetTeamList($id){
    $connection = connectDB();
    $teamList = $connection->prepare("SELECT * FROM Team WHERE tournament_id='$id'");
    $teamList->execute();
    $teamList = $teamList->fetchAll();
    $connection=NULL;
    return $teamList;
}
function dbGetNbTeam($tournament_id){
    $connection = connectDB();
    $nbTeam = $connection->prepare("SELECT * FROM Team WHERE tournament_id='$tournament_id'");
    $nbTeam->execute();
    $nbTeam = $nbTeam->rowCount();
    $connection = NULL;
    return $nbTeam;
}
function dbGetTeamById($id_team){
    $connection = connectdb();
    $teamById = $connection->prepare("SELECT * FROM Team WHERE id='$id_team'");
    $teamById->execute();
    $teamById = $teamById->fetch();
    $connection = NULL;
    return $teamById;
}
function dbGetInfoTeam($team_id){
    $connection = connectDB();
    $infoTeam = $connection->prepare("SELECT tournament_id, path_logo FROM Team WHERE id='$team_id'");
    $infoTeam->execute();
    $infoTeam= $infoTeam->fetch();
    $connection=NULL;
    return $infoTeam;
}
function dbInsertTeam($name, $tournament_id, $fileDestination){
    $connection = connectDB();
    $insertTeam = $connection->prepare("INSERT INTO Team (id, name, tournament_id, nb_visit, path_logo) VALUES (NULL, :name, :tournament_id, 0, :path_logo)");
    $insertTeam->bindParam(':name', $name);
    $insertTeam->bindParam(':tournament_id', $tournament_id);
    $insertTeam->bindParam(':path_logo', $fileDestination);
    $insertTeam->execute();
    $connection=NULL;
}
function dbUpdateTeam($team_name, $fileDestination, $id_team){
    $connection = connectDB();
    $updateTeam = $connection->prepare("UPDATE Team SET name='$team_name', path_logo='$fileDestination' WHERE id='$id_team'");
    $updateTeam->execute();
    $connection=NULL;
}
function dbDeleteTeam($team_id){
    $connection=connectDB();
    $deleteTeam = $connection->prepare("DELETE FROM Team WHERE id='$team_id'");
    $deleteTeam->execute();
    $connection=NULL;
}

//Day Table
function dbGetDayPlanning($id){
    $connection = connectDB();
    $dayPlanning = $connection->prepare("SELECT * FROM Day JOIN Planning ON Day.id = Planning.day_id WHERE tournament_id='$id'");
    $dayPlanning->execute();
    $dayPlanning = $dayPlanning->fetchAll();
    $connection=NULL;
    return $dayPlanning;
}
function dbGetDayList($tournament_id){
    $connection = connectDB();
    $dayList = $connection->prepare("SELECT * FROM Day WHERE tournament_id='$tournament_id'");
    $dayList->execute();
    $dayList = $dayList->fetchAll();
    $connection=NULL;
    return $dayList;
}
function dbInsertDay($tournament_id, $day_number) {
    $connection = connectDB();
    $insertDay = $connection->prepare("INSERT INTO Day (id, tournament_id, day_number, done) VALUES (NULL, :tournament_id, :day_number, 0)");
    $insertDay->bindParam(':tournament_id', $tournament_id);
    $insertDay->bindParam(':day_number', $day_number);
    $insertDay->execute();
    $connection=NULL;
}

//Planning Table
function dbInsertPlanning($day_id, $teamA_name, $teamB_name) {
    $connection = connectDB();
    $insertPlanning = $connection->prepare("INSERT INTO Planning (id, day_id, teamA_name, teamB_name, teamA_nbGoal, teamB_nbGoal) VALUES (NULL, :day_id, :teamA_name, :teamB_name, NULL, NULL)");
    $insertPlanning->bindParam(':day_id', $day_id);
    $insertPlanning->bindParam(':teamA_name', $teamA_name);
    $insertPlanning->bindParam(':teamB_name', $teamB_name);
    $insertPlanning->execute();
    $connection=NULL;
}
