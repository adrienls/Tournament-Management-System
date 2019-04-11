<?php

session_start();

if(isset($_SESSION['username'])){
    echo "<form action='../../../Controller/controller-CRUDTournament.php?func=createTournament' method='post'>
        Name: <input type='text' name='tournamentName'/>
        <br>
        Number of team : <input type='number' step='0.1' name='nbTeam'/>
        <br>";
        if(isset($_GET['error'])){
            if($_GET['error'] == "field_missing_or_nb_invalid") {echo "<br><b style='color:red;'>Fill all the fields ! (nb of teams > 0)</b><br>";}
            if($_GET['error'] == "name_used") {echo "<br><b style='color:red;'>Name already used !</b><br/>";}
        }
        echo "<br/><input type='submit' value='Submit'/>
    </form>";
}
else {
    require_once "../../../Controller/controller-GlobalFunctions.php";
    redirect("../../index.php?error=access_denied");
}


