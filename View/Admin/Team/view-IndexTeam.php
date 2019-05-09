<?php
/**
 * Created by PhpStorm.
 * User: adrien
 * Date: 04/04/19
 * Time: 08:31
 */
require_once "../../../Controller/controller-Global.php";

session_start();

if(!isset($_SESSION['username'])){
    redirect("../../index.php?error=bad_login");
}

else {
    require_once "../../../Controller/controller-Team.php";
    require_once "../../../Model/Planning.php";

    echo "<h2>Tournament : ".$_GET['name']."</h2>";
    $id=$_GET["id"];
    $team = getTeamById($id);
    echo "<h3>Team : ".$team->getName()."</h3>";
    echo "<h4>Number of visit : ".$team->getNbVisit()."</h4>";
    $team->updateNbVisit($id,$team->getNbVisit());
    //$image="../../../Images/1555691323.PNG";
    //echo $image.'<br>';
    $image=$team->getPathLogo();
    $image="../../".$image;
    echo "logo :";
    print '<img src='.$image.' width="100" height="100"/>';
    $listOfMatch = getMatchOfTeam($team->getName());
    echo "<br>";
    echo "<table style=\"text-align:center\"><tr><th>Team A </th><th>Team B</th><th>Goal A</th><th>Goal B</th></tr>";
    foreach ($listOfMatch as $match){
        echo "<tr>
            <td>".$match->getTeamAName()."</td>
            <td>".$match->getTeamBName()."</td>
            <td>".$match->getTeamANbGoal()."</td>
            <td>".$match->getTeamBNbGoal()."</td>
            </tr>";
    }
    echo "</table>";

}