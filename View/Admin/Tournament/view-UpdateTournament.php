<?php

require_once "../../../Controller/controller-Tournament.php";

session_start();

if(isset($_SESSION['username'])) {
    if(isset($_GET['id'])) {
        require_once "../../../Model/Database.php";
        $id = $_GET['id'];
        echo "<h1>Update Tournament</h1>
        <form action=\"../../../Controller/controller-Tournament.php?func=editTournament&&id=".$id."\" method=\"post\" >";
            $tournament = getTournamentById($id);
            echo "Name : <input type='text' name='tournament_name' value='".$tournament->getName()."'/>
            <br>
            Number of team : <input type='number' step=\"1\" min=\"0\" name='nb_team' value='".$tournament->getNbTeam()."'/>
            <br>";
            if(isset($_GET['error'])){
                if($_GET['error'] == "field_missing") {echo "<br><b style='color:red;'>Fill all the fields !</b><br>";}
                if($_GET['error'] == "number_invalid") {echo "<br><b style='color:red;'>Enter a valid number of teams (>0) !</b><br>";}
                if($_GET['error'] == "number_use") {echo "<br><b style='color:red;'>Enter a valid number of team !</b><br>";}

            }
            echo "<br>
            <input type='submit' value='Submit'/>
        </form>";
    }
}
else {
    require_once "../../../Controller/controller-Global.php";
    redirect("../index.php?error=access_denied");
}