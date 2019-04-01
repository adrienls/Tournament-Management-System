<?php
/**
 * Created by PhpStorm.
 * User: arthu
 * Date: 01/04/2019
 * Time: 19:32
 */
include "../../Controller/CRUDTournament.php";
session_start();
if(isset($_SESSION['username'])) {
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        echo "<h1>Modifier Etudiant</h1>
        <form action=\"../../Controller/CRUDTournament.php?func=editTournament&&id=".$id."\" method=\"post\" >";
        editTournamentView($id);
        echo "<input type='submit' value='Valider'/>
        </form>";
    }
}
else {
    header("Location: ../index.php?error=bad_login");
    exit();
}