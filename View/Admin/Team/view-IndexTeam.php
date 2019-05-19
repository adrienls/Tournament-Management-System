<?php
require_once "../../../Controller/controller-Global.php";
require_once "../../../Controller/controller-Team.php";
require_once "../../../Model/Planning.php";

if(!isIdentified()) {
    redirect("../../index.php?error=bad_login");
}
else {
    $id = $_GET["id"];
    $team = getTeamById($id);
    $image = $team->getPathLogo();
    $image = "../../".$image;
    $listOfMatch = getMatchOfTeam($team->getName());
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
    <link rel="shortcut icon" href="../../vendors/img/favicon.ico">
    <link rel="stylesheet" href="../../vendors/css/style.css">
    <link rel="stylesheet" href="../../vendors/@coreui/icons/css/coreui-icons.min.css">
    <link rel="stylesheet" href="../../vendors/font-awesome/css/font-awesome.min.css">
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show sidebar-minimized brand-minimized">
<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="../../index.php">
        <img class="navbar-brand-full" src="../../vendors/img/brand/logo.svg" width="89" height="25" alt="CoreUI Logo">
        <img class="navbar-brand-minimized" src="../../vendors/img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo">
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
    </div>
    <main class="main">
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col">
                        <?php
                        echo '<p><h3>Team : '.$team->getName().'</h3></p>';
                        echo '<p><h4>Number of visit : '.$team->getNbVisit().'</h4></p></div>';
                        echo "<div class='col'><img src=".$image." width='100' height='100'/>";
                        ?>
                    </div>
                </div>
                <table class="table" >
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Day</th>
                        <th scope="col">Home</th>
                        <th scope="col">Score</th>
                        <th scope="col">Away</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $dayNumber = 0;
                    foreach ($listOfMatch as $match) {
                        $dayNumber++;
                        echo "<tr>
                                  <td>".$dayNumber."</td>
                                  <td>".$match->getTeamAName()."</td>
                                  <td>".$match->getTeamANbGoal()." - ".$match->getTeamBNbGoal()."</td>
                                  <td>".$match->getTeamBName()."</td>
                              </tr>";
                    }?>
                    </tbody>
                </table>
                <?php echo "<a class='btn btn-dark' href=\"../Tournament/view-IndexTournament.php?id=".$_GET['tournament_id']."&name=".$_GET['name']."\" role='button'>Back</a>"; ?>
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
<script src="../../vendors/jquery/jquery.min.js"></script>
<script src="../../vendors/@coreui/coreui/coreui.min.js"></script>
</body>
</html>
