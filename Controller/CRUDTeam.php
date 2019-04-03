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
function viewTeam($id){

    $connection = connectDB();
    //Tournaments Recovery
    $queryTeams = $connection->prepare("SELECT * FROM Team WHERE tournament_id=$id");
    $queryTeams->execute();
    $teams = $queryTeams->fetchAll();
    //Display
    echo "<table><tr><tr>Name&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</tr><tr>Nb of visit &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</tr></th>Logo </tr></th>";
    foreach($teams as $team) {
        echo "<tr>
            <td>".$team['name']."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
            <td>".$team['nb_visit']."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
            <td><a href=\"editTeam.php?id=".$team['id']."\">Edit</a></td>
            <td><a href=\"../../Controller/CRUDTeam.php?func=deleteTeam&&id=".$team['id']."\">Delete</a></td>
            </tr>";
    }
    echo "</table>";

    $connection = NULL;
}

function createTeam($tournament_id) {

    //Connection to database
    $connection = connectDB();

    //Fields recovery
    $name = $_POST['name'];

    //Verification of all fields
    if(empty($name) || empty($_FILES['logo']['name'])){
        redirect("../View/Admin/newTeam.php?id=".$tournament_id."&error=field_missing");
    }

    //Name verification
    $queryTeams = $connection->prepare("SELECT * FROM Team WHERE tournament_id='$tournament_id'");
    $queryTeams->execute();
    $dbTeams = $queryTeams->fetchAll();
    foreach ($dbTeams as $team) {
        if($name == $team['name']){
            redirect("../View/Admin/newTeam.php?id=".$tournament_id."&error=name_used");
        }
    }

    //Logo path verification
    $file = $_FILES['logo']['tmp_name'];
    $nameNewFile=$_FILES['logo']['name'];
    $extension=strrchr($nameNewFile,".");
    $fileDestination = '../Images/'.time().$extension;
    $fileSize = $_FILES['logo']['size'];
    if($fileSize > 100000) {
        redirect("../View/Admin/newTeam.php?id=".$tournament_id."&error=logo_invalid");
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

function editTeam($id_team){

    $connection = connectDB();

    $team_name = $_POST['name'];

    if(empty($team_name)){
        redirect("../View/Admin/editTeam.php?id=".$id_team."&error=need_name");
    }

    //Verification of the unique name of team
    $queryIdTournament = $connection->prepare("SELECT tournament_id FROM Team WHERE id='$id_team'");
    $queryIdTournament->execute();
    $id_tournament = $queryIdTournament->fetchColumn();
    $queryTeams = $connection->prepare("SELECT * FROM Team WHERE tournament_id='$id_tournament'");
    $queryTeams->execute();
    $dbTeams = $queryTeams->fetchAll();
    foreach ($dbTeams as $team) {
        if($team_name == $team['name']){
            redirect("../View/Admin/editTeam.php?id=".$id_team."&error=name_used");
        }
    }

    $file = $_FILES['logo']['tmp_name'];
    $fileDestination = '../Images/'.time().'.txt';
    $fileSize = $_FILES['logo']['size'];
    if($fileSize > 100000) {
        redirect("../View/Admin/newTeam.php?id=".$id_team."&error=logo_invalid");
    }
    move_uploaded_file($file,$fileDestination);

    //Informations sending
    $insert = $connection->prepare("UPDATE Team SET name='$team_name', path_logo='$fileDestination' WHERE id='$id_team'");
    $insert->execute();
    redirect("../View/Admin/tournamentManagement.php?id=".$id_tournament."&success=update");

}

function editTeamView($id_team){

    $connection = connectDB();

    $queryInfos = $connection->prepare("SELECT * FROM Team WHERE id='$id_team'");
    $queryInfos->execute();
    $info = $queryInfos->fetch();
    var_dump($info['path_logo']);

    echo "Name : <input type='text' name='name' value='".$info['name']."'/>
    <br>
    Logo : <input type='file' name='logo' size='100000' value='".$info['path_logo']."'/>
    <br>";

}

function testNumberMaxTeam($tournament_id){
    $connection = connectDB();

    $queryNbTeamMax = $connection->prepare("SELECT nb_team FROM Tournament WHERE id='$tournament_id'");
    $queryNbTeamMax->execute();
    $nbTeamMax = $queryNbTeamMax->fetchColumn();

    $queryNbTeam = $connection->prepare("SELECT * FROM Team WHERE tournament_id='$tournament_id'");
    $queryNbTeam->execute();
    $nbTeam = $queryNbTeam->rowCount();

    if($nbTeam<$nbTeamMax){
        return 1;
    }
    else{
        return 0;
    }
}