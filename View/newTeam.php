<?php
session_start();
$tournament_id = 1;
if(isset($_SESSION['username'])){
    echo "
    <h2>New Team</h2>
    <form action=\"../Controller/newTeam.php?func=newTeam&&id=".$tournament_id."\" method='post'>
        Name : <input type='text' name='name'/>
        <br>
        Logo : <input type='text' name='logo'/>
        <br>";
        if(isset($_GET['error'])){
            if($_GET['error'] == "field_missing") {echo "<br><b style='color:red;'>Fill all the fields !</b><br>";}
            if($_GET['error'] == "name_used") {echo "<br><b style='color:red;'>Name already used !</b><br>";}
            if($_GET['error'] == "logo_invalid") {echo "<br><b style='color:red;'>Image URL is invalid !</b><br>";}
        }
        echo "
        <br>
        <input type='submit' value='Submit'/>
    </form>";
}
else {
    require_once "../Controller/redirect.php";
    redirect("index.php");
}