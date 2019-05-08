<?php

require_once "../../../Controller/controller-Tournament.php";

session_start();

if(isset($_SESSION['username'])) {
    if(isset($_GET['id'])) {
        require_once "../../../Model/Database.php";
        $id = $_GET['id'];
        echo "<h2>Update Tournament</h2>
        <form action=\"../../../Controller/controller-Tournament.php?func=editTournament&id=".$id."\" method=\"post\" >";
            $tournament = getTournamentById($id);
            echo "Name : <input type='text' name='tournament_name' value='".$tournament->getName()."'/>
            <br>
            Number of team : <input type='number' step=\"1\" min=\"0\" name='nb_team' value='".$tournament->getNbTeam()."'/>
            <br>";
            if(isset($_GET['error'])){
                if($_GET['error'] == "field_missing") {echo "<br><b style='color:red;'>Fill all the fields !</b><br>";}
                if($_GET['error'] == "number_invalid") {echo "<br><b style='color:red;'>Enter a valid number of teams (>0) !</b><br>";}
                if($_GET['error'] == "teams_already_created") {echo "<br><b style='color:red;'>You need to delete teams before !</b><br>";}
                if($_GET['error'] == "days_already_generated") {echo "<br><b style='color:red;'>Days are already generated, you can't change the number of teams !</b><br>";}
            }
            echo "<br>
            <input type='submit' value='Submit'/>
        </form>
        <a href=\"../view-IndexAdmin.php\">Back</a>";
    }
}
else {
    require_once "../../../Controller/controller-Global.php";
    redirect("../index.php?error=access_denied");
}