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

function viewTeam($id,$tournamentName){
    require_once "../../../Model/model-DB.php";
    //Tournaments Recovery
    $teams = getTeamList($id);
    //Display
    echo "<table><tr><th>Name</th><th>NbOfVisit</th><th>Logo</th></tr>";
    foreach($teams as $team) {
        echo "<tr>
            <td>".$team['name']."</td>
            <td>".$team['nb_visit']."</td>
            <td></td>
            <td><a href=\"../Team/view-UpdateTeam.php?id=".$team['id']."&&name=".$tournamentName."\">Edit</a></td>
            <td><a href=\"../../../Controller/controller-CRUDTeam.php?func=deleteTeam&&id=".$team['id']."&&name=".$tournamentName."\">Delete</a></td>
            </tr>";
    }
    echo "</table>";

    $connection = NULL;
}

function createTeam($tournament_id) {
    require_once "../Model/model-DB.php";
    //Fields recovery
    $name = $_POST['name'];

    //Verification of all fields
    if(empty($name) || empty($_FILES['logo']['name'])){
        redirect("../View/Admin/Team/view-CreateTeam.php?id=".$tournament_id."&name=".$_GET['name']."&error=field_missing");
    }

    //Name verification

    $dbTeams = getTeamList($tournament_id);
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
    move_uploaded_file($file,$fileDestination);

    //VERIFICATION TAILLE + DIMENSIONS

    //Informations sending
    insertTeam($name, $tournament_id, $fileDestination);
    redirect("../View/Admin/Tournament/view-IndexTournament.php?id=".$tournament_id."&name=".$_GET['name']."");

}

function deleteTeam($team_id) {
    require_once "../Model/model-DB.php";
    $infoTeam= modelInfoTeam($team_id);

    $tournament_id = $infoTeam['tournament_id'];
    $pathLogo= $infoTeam['path_logo'];

    if(file_exists($pathLogo))
        unlink( $pathLogo ) ;
    modelDeleteTeam($team_id);
    redirect("../View/Admin/Tournament/view-IndexTournament.php?id=".$tournament_id."&name=".$_GET['name']."&success=delete");
}

function editTeam($id_team){
    require_once "../Model/model-DB.php";

    $team_name = $_POST['name'];

    if(empty($team_name)){
        redirect("../View/Admin/Team/view-UpdateTeam.php?id=".$id_team."&name=".$_GET['name']."&error=need_name");
    }

    //Verification of the unique name of team
    $infoTeam = infoTeam($id_team);

    $id_tournament = $infoTeam['tournament_id'];
    $pathLogo= $infoTeam['path_logo'];

    $dbTeams = Teams($id_tournament);
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
    modelUpdateTeam($team_name,$fileDestination,$id_team);
    redirect("../View/Admin/Tournament/view-IndexTournament.php?id=".$id_tournament."&name=".$_GET['name']."&success=update");

}

function editTeamView($id_team){
    require_once "../../../Model/model-DB.php";
    $info = info($id_team);

    echo "Name : <input type='text' name='name' value='".$info['name']."'/>
    <br>
    Logo : <input type='file' name='logo' size='100000'/>
    <br>";

}

function testNumberMaxTeam($tournament_id){
    require_once "../../../Model/model-DB.php";

    $nbTeamMax = nbTeamMax($tournament_id);
    $nbTeam = nbTeam($tournament_id);

    if($nbTeam<$nbTeamMax){
        return 1;
    }
    else{
        return 0;
    }
}