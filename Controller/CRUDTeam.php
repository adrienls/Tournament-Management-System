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

function viewTeam($id,$tournamentName){

    $connection = connectDB();
    //Tournaments Recovery
    $queryTeams = $connection->prepare("SELECT * FROM Team WHERE tournament_id=$id");
    $queryTeams->execute();
    $teams = $queryTeams->fetchAll();
    //Display
    echo "<table><tr><th>Name</th><th>NbOfVisit</th><th>Logo</th></tr>";
    foreach($teams as $team) {
        echo "<tr>
            <td>".$team['name']."</td>
            <td>".$team['nb_visit']."</td>
            <td></td>
            <td><a href=\"editTeam.php?id=".$team['id']."&&name=".$tournamentName."\">Edit</a></td>
            <td><a href=\"../../Controller/CRUDTeam.php?func=deleteTeam&&id=".$team['id']."&&name=".$tournamentName."\">Delete</a></td>
            </tr>";
    }
    echo "</table>";

    $connection = NULL;
}

function createTeam($tournament_id) {
    $connection = connectDB();

    //Fields recovery
    $name = $_POST['name'];

    //Verification of all fields
    if(empty($name) || empty($_FILES['logo']['name'])){
        redirect("../View/Admin/newTeam.php?id=".$tournament_id."&name=".$_GET['name']."&error=field_missing");
    }

    //Name verification
    $queryTeams = $connection->prepare("SELECT * FROM Team WHERE tournament_id='$tournament_id'");
    $queryTeams->execute();
    $dbTeams = $queryTeams->fetchAll();
    foreach ($dbTeams as $team) {
        if($name == $team['name']){
            redirect("../View/Admin/newTeam.php?id=".$tournament_id."&name=".$_GET['name']."&error=name_used");
        }
    }

    //Logo path verification
    $file = $_FILES['logo']['tmp_name'];
    $nameNewFile=$_FILES['logo']['name'];
    $extension=strrchr($nameNewFile,".");
    $fileDestination = '../Images/'.time().$extension;
    $fileSize = $_FILES['logo']['size'];
    if($fileSize > 100000) {
        redirect("../View/Admin/newTeam.php?id=".$tournament_id."&name=".$_GET['name']."&error=logo_invalid");
    }
    move_uploaded_file($file,$fileDestination);

    //VERIFICATION TAILLE + DIMENSIONS

    //Informations sending
    $insert = $connection->prepare("INSERT INTO Team (id, name, tournament_id, nb_visit, path_logo) VALUES (NULL, :name, :tournament_id, 0, :path_logo)");
    $insert->bindParam(':name', $name);
    $insert->bindParam(':tournament_id', $tournament_id);
    $insert->bindParam(':path_logo', $fileDestination);
    $insert->execute();
    redirect("../View/Admin/tournamentManagement.php?id=".$tournament_id."&name=".$_GET['name']."");

}

function deleteTeam($team_id) {

    $connection = connectDB();
    $queryIdPathTournament = $connection->prepare("SELECT tournament_id, path_logo FROM Team WHERE id='$team_id'");
    $queryIdPathTournament->execute();
    $infoTeam= $queryIdPathTournament->fetch();

    $tournament_id = $infoTeam['tournament_id'];
    $pathLogo= $infoTeam['path_logo'];

    if(file_exists($pathLogo))
        unlink( $pathLogo ) ;
    $delete = $connection->prepare("DELETE FROM Team WHERE id='$team_id'");
    $delete->execute();
    redirect("../View/Admin/tournamentManagement.php?id=".$tournament_id."&name=".$_GET['name']."&success=delete");
}

function editTeam($id_team){

    $connection = connectDB();

    $team_name = $_POST['name'];

    if(empty($team_name)){
        redirect("../View/Admin/editTeam.php?id=".$id_team."&name=".$_GET['name']."&error=need_name");
    }

    //Verification of the unique name of team
    $queryIdPathTournament = $connection->prepare("SELECT tournament_id, path_logo FROM Team WHERE id='$id_team'");
    $queryIdPathTournament->execute();
    $infoTeam= $queryIdPathTournament->fetch();

    $id_tournament = $infoTeam['tournament_id'];
    $pathLogo= $infoTeam['path_logo'];

    $queryTeams = $connection->prepare("SELECT * FROM Team WHERE tournament_id='$id_tournament'");
    $queryTeams->execute();
    $dbTeams = $queryTeams->fetchAll();
    foreach ($dbTeams as $team) {
        if($team_name == $team['name']){
            redirect("../View/Admin/editTeam.php?id=".$id_team."&name=".$_GET['name']."&error=name_used");
        }
    }

    $file = $_FILES['logo']['tmp_name'];
    $nameNewFile=$_FILES['logo']['name'];
    $extension=strrchr($nameNewFile,".");
    $fileDestination = '../Images/'.time().$extension;
    $fileSize = $_FILES['logo']['size'];
    if($fileSize > 100000) {
        redirect("../View/Admin/newTeam.php?id=".$id_team."&name=".$_GET['name']."&error=logo_invalid");
    }
    if(file_exists($pathLogo))
        unlink( $pathLogo ) ;
    move_uploaded_file($file,$fileDestination);

    //Informations sending
    $insert = $connection->prepare("UPDATE Team SET name='$team_name', path_logo='$fileDestination' WHERE id='$id_team'");
    $insert->execute();
    redirect("../View/Admin/tournamentManagement.php?id=".$id_tournament."&name=".$_GET['name']."&success=update");

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