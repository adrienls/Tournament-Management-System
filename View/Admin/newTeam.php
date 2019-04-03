<?php

session_start();


if(isset($_SESSION['username'])){
    require_once "../../Controller/CRUDTeam.php";
    $tournament_id = $_GET["id"];
    var_dump(testNumberMaxTeam($tournament_id));
    if(testNumberMaxTeam($tournament_id)){
        echo "<h2>New Team</h2>
        <form action=\"../../Controller/CRUDTeam.php?func=createTeam&&id=".$tournament_id."\" method='post' enctype='multipart/form-data'>
            Name : <input type='text' name='name'/>
            <br>
            Logo : <input type='file' name='logo' size='100000'/>
            <br>";
                if(isset($_GET['error'])){
                if($_GET['error'] == "field_missing") {echo "<br><b style='color:red;'>Fill all the fields !</b><br>";}
                if($_GET['error'] == "name_used") {echo "<br><b style='color:red;'>Name already used !</b><br>";}
                if($_GET['error'] == "logo_invalid") {echo "<br><b style='color:red;'>Logo is too big !</b><br>";}
            }
            echo "<br><input type='submit' value='Submit'/>
        </form>";
    }
    else{
        require_once "../../Controller/GlobalFunctions.php";
        redirect("./tournamentManagement.php?id=".$tournament_id."&error=max_number_of_team");
    }

}

else {
    require_once "../../Controller/GlobalFunctions.php";
    redirect("../index.php?error=access_denied");
}