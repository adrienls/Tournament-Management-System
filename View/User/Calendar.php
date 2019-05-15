<?php
require_once "../../Model/Team.php";
require_once "../../Model/Tournament.php";
require_once "../../Controller/controller-Global.php";
require_once "../../Controller/controller-Planning.php";
require_once "../../Model/Day.php";

if(isset($_GET["id"])) {
    $tournamentId = $_GET["id"];
    $tournament = getTournamentById($tournamentId);
    $tournamentName = $tournament->getName();
    $days = getDayList($tournamentId);
}
else{
    redirect("../index.php");
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
    <link rel="shortcut icon" href="../template/img/favicon.ico">
    <link rel="stylesheet" href="../template/css/style.css">
    <link rel="stylesheet" href="../template/@coreui/icons/css/coreui-icons.min.css">
    <link rel="stylesheet" href="../template/font-awesome/css/font-awesome.min.css">
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="../index.php">
        <img class="navbar-brand-full" src="../template/img/brand/logo.svg" width="89" height="25" alt="CoreUI Logo">
        <img class="navbar-brand-minimized" src="../template/img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo">
    </a>
    <h1 class="nav navbar-nav ml-auto" style="font-family: CoreUI-Icons-Linear-Free">Tournament Management System</h1>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" href="../Admin/view-Login.php" role="button">
                <i class="cui-dashboard btn-lg"> Admin</i>
            </a>
        </li>
    </ul>
</header>
<div class="app-body">
    <div class="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav">
                <div class="nav-divider"></div>
                <li class="nav-title">Dashboard</li>
                <li class="nav-item">
                    <?php echo '<a class="nav-link" href="Tournament.php?id='.$tournamentId.'">
                    <i class="nav-icon fa fa-users fa-fw"></i> Teams</a>'; ?>
                </li>
                <li class="nav-item">
                    <?php echo '<a class="nav-link" href="Rankings.php?id='.$tournamentId.'">
                    <i class="nav-icon fa fa-eye fa-fw"></i> Rankings</a>'; ?>
                </li>
                <li class="nav-item">
                    <?php echo '<a class="nav-link" href="Calendar.php?id='.$tournamentId.'">
                    <i class="nav-icon fa fa-calendar fa-fw"></i> Calendar</a>'; ?>
                </li>
                <li class="nav-item">
                    <?php echo '<a class="nav-link" href="News.php?id='.$tournamentId.'">
                    <i class="nav-icon fa fa-history fa-fw"></i> News</a>'; ?>
                </li>
            </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="../index.php">Tournament Selection</a>
            </li>
            <li class="breadcrumb-item">
                <?php echo "<a href='Tournament.php?id=$tournamentId'>$tournamentName</a>";?>
            </li>
            <li class="breadcrumb-item">
                <?php echo "<a href='Calendar.php?id=$tournamentId'>Calendar</a>";?>
            </li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col">
                        <?php
                        echo '<h3 style="font-family: CoreUI-Icons-Linear-Free">Calendar from '.$tournamentName.'</h3>';
                        echo "<p><a class='btn btn-primary btn-sm' href=\"../../Controller/controller-Planning.php?func=exportPlanning&id=".$tournamentId."&name=".$tournamentName."\" role='button'>Export</a></p>";
                        ?>
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Day</th>
                        <th scope="col">Home</th>
                        <th scope="col">Score</th>
                        <th scope="col">Away</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($days as $day) {
                        $listOfMatch = getMatchesList($day->getId());
                        foreach ($listOfMatch as $match) {
                            echo "<tr>
                            <td>".$day->getDayNumber()."</td>
                            <td>".$match->getTeamAName()."</td>
                            <td>".$match->getTeamANbGoal()." - ".$match->getTeamBNbGoal()."</td>
                            <td>".$match->getTeamBName()."</td>
                        </tr>";
                        }
                    }
                    ?>
                    </tbody>
                </table>
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
<script src="../template/jquery/jquery.min.js"></script>
<script src="../template/@coreui/coreui/coreui.min.js"></script>
</body>
</html>