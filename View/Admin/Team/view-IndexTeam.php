<?php
/**
 * Created by PhpStorm.
 * User: adrien
 * Date: 04/04/19
 * Time: 08:31
 */
require_once "../../../Controller/controller-Global.php";

if(!isIdentified()){
    redirect("../../index.php?error=bad_login");
}

else {
    require_once "../../../Controller/controller-Team.php";
    require_once "../../../Model/Planning.php";

    echo "<h2>Tournament : ".$_GET['name']."</h2>";
    $id=$_GET["id"];
    $team = getTeamById($id);
    echo "<h3>Team : ".$team->getName()."</h3>";
    $image=$team->getPathLogo();
    $image="../../".$image;
    print '<img src='.$image.' width="100" height="100"/>';
    echo "<h4>Number of visit : ".$team->getNbVisit()."</h4>";
    $team->updateNbVisit($id,$team->getNbVisit());
    echo "<h3>Matchs</h3>";
    $listOfMatch = getMatchOfTeam($team->getName());
    echo "<table style=\"text-align:center\"><tr><th>Home</th><th>Score</th><th>Away</th></tr>";
    foreach ($listOfMatch as $match){
        echo "<tr>
            <td>".$match->getTeamAName()."</td>
            <td>".$match->getTeamANbGoal()." - ".$match->getTeamBNbGoal()."</td>
            <td>".$match->getTeamBName()."</td>
            </tr>";
    }
    echo "</table>";

}