<?php
/**
 * Created by PhpStorm.
 * User: arthu
 * Date: 03/04/2019
 * Time: 00:08
 */

require_once "../../../Controller/controller-CRUDTeam.php";

session_start();

if(isset($_SESSION['username'])) {
    if(isset($_GET['id'])) {
        $id_team = $_GET['id'];
        echo "<h1>Update Team</h1>
        <form action=\"../../../Controller/controller-CRUDTeam.php?func=editTeam&id=".$id_team."&name=".$_GET['name']."\" method=\"post\" enctype='multipart/form-data'>";
        editTeamView($id_team);
        if(isset($_GET['error'])){
            if($_GET['error'] == "need_name") {echo "<br><b style='color:red;'>Fill at least the name !</b><br>";}
            if($_GET['error'] == "name_used") {echo "<br><b style='color:red;'>Put a new name !</b><br>";}
            if($_GET['error'] == "number_invalid") {echo "<br><b style='color:red;'>Enter a valid logo</b><br>";}
        }
        echo "<br>
            <input type='submit' value='Submit'/>
        </form>";
    }
}
else {
    require_once "../../Controller/controller-GlobalFunctions.php";
    redirect("../index.php?error=access_denied");
}