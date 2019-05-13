<?php

require_once "../../../Controller/controller-Global.php";

if(!isIdentified()){
    redirect("../../index.php?error=bad_login");
}

else {
    require_once "../../../Controller/controller-Days.php";
    require_once "../../../Controller/controller-Planning.php";
    require_once "../../../Controller/controller-Tournament.php";

    echo "<h2>".$_GET['name']." Management</h2>";

    if(!testNumberMaxTeam($_GET['id']) && !isGeneratedDays($_GET['id'])){
        echo "<a href=\"../../../Controller/controller-Days.php?func=generateDays&id=".$_GET["id"]."&name=".$_GET["name"]."\">GenerateDays</a></br>";
    }
    if(isGeneratedDays($_GET['id'])) {
        echo "<a href=\"../../../Controller/controller-Days.php?func=playDay&id=".$_GET["id"]."&name=".$_GET['name']."\">PlayDay</a><br>";
    }
    if(isset($_GET['error'])){
        if($_GET['error'] == "all_days_played") {echo "<br><b style='color:darkred;'>All days are played !</b><br>";}
    }
    if(isset($_GET['success'])) {
        if($_GET['success'] == "generate") {echo "<br><b style='color:green;'>Days & Matches generated !</b><br>";}
        if($_GET['success'] == "play") {echo "<br><b style='color:green;'>Day ".$_GET['day_number']." played !</b><br>";}
    }

    echo "<h3>Teams</h3>";
    echo "<a href=\"../Team/view-CreateTeam.php?id=".$_GET["id"]."&name=".$_GET['name']."\">New Team</a><br><br>";
    if(isset($_GET['error'])){
        if($_GET['error'] == "max_number_of_team") {echo "<b style='color:darkred;'>Max number of team reach !</b><br><br>";}
        if($_GET['error'] == "days_generated") {echo "<b style='color:darkred;'>Teams can't be erased once days are generated !</b><br><br>";}
    }
    if(isset($_GET['success'])){
        if($_GET['success'] == "new") {echo "<b style='color:green;'>Team created !</b><br><br>";}
        if($_GET['success'] == "update") {echo "<b style='color:green;'>Team updated !</b><br><br>";}
        if($_GET['success'] == "delete") {echo "<b style='color:green;'>Team erased !</b><br><br>";}
    }
    $teams = getTeamList($_GET["id"]);
    echo "<table style=\"text-align:center\"><tr><th>Name</th><th>NbOfVisit</th><th>Logo</th></tr>";
    foreach($teams as $team) {
        echo "<tr>
        <td><a href=\"../Team/view-IndexTeam.php?id=".$team->getId()."&name=".$_GET['name']."\">".$team->getName()."</td>
        <td>".$team->getNbVisit()."</td>
        <td></td>
        <td><a href=\"../Team/view-UpdateTeam.php?id=".$team->getId()."&name=".$_GET['name']."&tournament_id=".$_GET['id']."\">Edit</a></td>
        <td><a href=\"../../../Controller/controller-Team.php?func=deleteTeam&id=".$team->getId()."&name=".$_GET['name']."\">Delete</a></td>
        </tr>";
    }
    echo "</table>";

    if (isPlayedDays($_GET["id"])) {
        echo "<h3>Ranking</h3>";
        $rankings = getRankingsTournament($_GET['id']);
        $ranking = array_pop($rankings);
        echo "<table style=\"text-align:center\"><tr><th>Team</th><th>Score</th><th>GoalScored</th><th>GoalTaken</th></tr>";
        foreach($ranking as $name => $team) {
            echo "<tr>
            <td>".$name."</td>
            <td>".$team['score']."</td>
            <td>".$team['goalScored']."</td>
            <td>".$team['goalTaken']."</td>
            </tr>";
        }
        echo "</table>";
    }

    echo "<br><a href='../view-IndexAdmin.php'>Back</a>";
}