<?php

require_once "../../../Controller/controller-Global.php";

if(!isIdentified()){
    redirect("../../index.php?error=bad_login");
}

else {
    require_once "../../../Controller/controller-Days.php";
    require_once "../../../Controller/controller-Planning.php";
    require_once "../../../Controller/controller-Tournament.php";

    $teams = getTeamList($_GET["id"]);

    /*
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
        echo "<br><a href=\"../../../Controller/controller-Tournament.php?func=export&id=".$_GET['id']."&name=".$_GET['name']."\">Export</a>";

        echo "<br><a href='../view-IndexAdmin.php'>Back</a>";*/
}

?>
<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v2.1.12
* @link https://coreui.io
* Copyright (c) 2018 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Tournament Management System">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>Tournament Management System</title>
    <!-- Main style and icons for this application-->
    <link rel="shortcut icon" href="../../template/img/favicon.ico">
    <link rel="stylesheet" href="../../template/css/style.css">
    <link rel="stylesheet" href="../../template/@coreui/icons/css/coreui-icons.min.css">
    <link rel="stylesheet" href="../../template/font-awesome/css/font-awesome.min.css">
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="../../index.php">
        <img class="navbar-brand-full" src="../../template/img/brand/logo.svg" width="89" height="25" alt="CoreUI Logo">
        <img class="navbar-brand-minimized" src="../../template/img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo">
    </a>
    <h1 class="nav navbar-nav ml-auto">Tournament Management System</h1>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" href="../../../Controller/controller-Connect.php?func=logout" role="button">
                <i class="cui-dashboard btn-lg"> Disconnect</i>
            </a>
        </li>
    </ul>
</header>
<div class="app-body">
    <div class="sidebar">
        <nav class="sidebar-nav">
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>
    <main class="main">
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col">
                        <?php
                        echo "<p><h3>".$_GET['name']." Management</h3></p>";
                        if(!testNumberMaxTeam($_GET['id']) && !isGeneratedDays($_GET['id'])){
                            echo "<p><a class=\"btn btn-primary\" href=\"../../../Controller/controller-Days.php?func=generateDays&id=".$_GET["id"]."&name=".$_GET["name"]."\" role=\"button\">GenerateDays</a></p>";
                        }
                        else {
                            echo "<p><a class=\"btn btn-primary disabled\" tabindex=\"-1\" href='#' role=\"button\" aria-disabled='true'>GenerateDays</a></p>";
                        }
                        if(isGeneratedDays($_GET['id'])) {
                            echo "<p><a class=\"btn btn-primary\" href=\"../../../Controller/controller-Days.php?func=playDay&id=".$_GET["id"]."&name=".$_GET['name']."\" role=\"button\">PlayDay</a></p>";
                        }
                        else {
                            echo "<p><a class=\"btn btn-primary disabled\" tabindex=\"-1\" href='#' role=\"button\" aria-disabled='true'>PlayDay</a></p>";
                        }
                        if (isset($_GET['success'])) {
                            if ($_GET['success'] == "generate") {echo "<div class='alert alert-success' role='alert'>Days & Matches generated !</div>";}
                            if ($_GET['success'] == "play") {echo "<div class='alert alert-success' role='alert'>Day ".$_GET['day_number']." played !</div>";}
                        }
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == "all_days_played") {echo "<div class='alert alert-danger' role='alert'>All days are played !</div>";}
                        }
                        ?>
                    </div>
                </div>
                <table class="table">
                    <?php
                    echo "<p><h4>Teams</h4></p>";
                    echo "<p><a class='btn btn-primary' href=\"../Team/view-CreateTeam.php?id=".$_GET['id']."&name=".$_GET['name']."\" role='button'>New Team</a></p>";
                    if (isset($_GET['success'])) {
                        if($_GET['success'] == "new") {echo "<div class='alert alert-success' role='alert'>Team created !</div>";}
                        if($_GET['success'] == "update") {echo "<div class='alert alert-success' role='alert'>Team updated !</div>";}
                        if($_GET['success'] == "delete") {echo "<div class='alert alert-success' role='alert'>Team erased !</div>";}
                    }
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == "max_number_of_team") {echo "<div class='alert alert-danger' role='alert'>Max number of team reach !</div>";}
                        if ($_GET['error'] == "days_generated") {echo "<div class='alert alert-danger' role='alert'>Teams can't be erased once days are generated !</div>";}
                    }
                    ?>
                    <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($admins as $admin) {
                        if ($admin->getUsername() != "admin") {
                            echo "
                            <tr>
                                <td>".$admin->getUsername()."</td>
                                <td><a class=\"btn btn-ghost-primary\" href=\"view-UpdateAdmin.php?id=".$admin->getId()."\" role=\"button\">Edit</a></td>
                                <td><a class=\"btn btn-ghost-danger\" href=\"../../Controller/controller-Admin.php?func=deleteAdmin&id=".$admin->getId()."\" role=\"button\">Delete</a></td>
                            </tr>";
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <?php
                if(isset($_GET['success'])){
                    if($_GET['success'] == "new") {echo "<div class='alert alert-success' role='alert'>Admin created !</div>";}
                    if($_GET['success'] == "update") {echo "<div class='alert alert-success' role='alert'>Admin updated !</div>";}
                    if($_GET['success'] == "delete") {echo "<div class='alert alert-success' role='alert'>Admin erased !</div>";}
                }
                ?>
                <a class="btn btn-dark" href="../view-IndexAdmin.php" role="button">Back</a>
            </div>
        </div>
    </main>
</div>
<footer class="app-footer">
    <div>
        <i class="fa fa-github"></i>
        <a href="https://github.com/adrienls/Tournament-Management-System">Source Code</a>
        <span>&copy; 2019 ISEN Nantes CIR2.</span>
    </div>
    <div class="ml-auto">
        <span>Powered by Alexis Decamp, Arthur Guerineau and Adrien Le Saux</span>
    </div>
</footer>
<!-- CoreUI and necessary plugins-->
<script src="../../template/jquery/jquery.min.js"></script>
<script src="../../template/@coreui/coreui/coreui.min.js"></script>
</body>
</html>