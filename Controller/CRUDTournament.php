<?php
/**
 * Created by PhpStorm.
 * User: arthu
 * Date: 01/04/2019
 * Time: 16:00
 */

require_once "GlobalFunctions.php";
//require_once "../Model/DBConfig.php";

if(isset($_GET['func'])) {
    if(isset($_GET['id'])){
        $_GET['func']($_GET['id']);
    }
    else {
        $_GET['func']();
    }
}


function createTournament() {
    echo "hihi";
    $connection = connectDB();

    $tournamentName = $_POST['tournamentName'];
    $nbTeam = $_POST['nbTeam'];

    if(empty($tournamentName) || $nbTeam==0){
        redirect("../View/Admin/newTournament.php?error=field_missing_or_nb_invalid");
    }

    //Name verification
    $queryTournament = $connection->prepare("SELECT * FROM Tournament");
    $queryTournament->execute();
    $dbTournament = $queryTournament->fetchAll();
    foreach ($dbTournament as $tournament) {
        if($tournamentName == $tournament['name']){
            redirect("../View/Admin/newTournament.php?error=name_used");
        }
    }

    //Informations sending
    $insert = $connection->prepare("INSERT INTO Tournament (id, name, nb_team) VALUES (NULL, :names, :nb_team)");
    $insert->bindParam(':names', $tournamentName);
    $insert->bindParam(':nb_team', $nbTeam);
    $insert->execute();
    redirect("../View/Admin/adminView.php?ajout=ok");

}

function editTournamentView($id) {

    $connection = connectDB();

    $querryTournament = $connection->prepare("SELECT * FROM Tournament WHERE id='$id'");
    $querryTournament->execute();
    $Tournaments = $querryTournament->fetch();

    echo "Name : <input type='text' name='Tournamentname' value='".$Tournaments['name']."'/>
    <br>
    Number of team : Number of team in the tournament : <input type='number' step=\"1\" min=\"0\" name='nb_team' value='".$Tournaments['nb_team']."'/>
    <br>
    <br><br>";
    if(!empty($_GET["note"])){        echo "<span style=\"color:red;\">Note invalide ! </span><br>";}
    if(!empty($_GET["error"])){        echo "<span style=\"color:red;\">Il manque une info! </span><br>";}

}
function editTournament(){
    $connection = connectDB();

    session_start();
    $tournament_id = $_SESSION['id'];


    if(empty($_POST['name']) || empty($_POST['nb_team'])){
        //redirect("editTournament.php?id=$tournament_id&error=bad_info");
    }

    //Verification de la note
    if($_POST['nb_team'] < 0){
        redirect("editetudiant.php?id=$tournament_id&note=bad_note");
    }

    $querryTournament = $connection->prepare("UPDATE Tournament SET name='".$_POST['name']."', nb_team='".$_POST['nb_team']."' WHERE id='$tournament_id'");
    $querryTournament->execute();
    redirect("viewAdmin.php?modif=ok");
}