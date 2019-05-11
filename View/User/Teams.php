<?php
require_once "../../Controller/controller-Team.php";
require_once "../../Controller/controller-Tournament.php";
require_once "../../Controller/controller-Global.php";

if(isset($_GET["id"])) {
    $id = $_GET["id"];
    $teams = getTeamList($id);
    $tournament = getTournamentById($id);
    $name = $tournament->getName();
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
                    <a class="nav-link" href="../User/Teams.php">
                        <i class="nav-icon fa fa-users fa-fw"></i> Teams</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../User/Rankings.php">
                        <i class="nav-icon fa fa-eye fa-fw"></i> Rankings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../User/Calendar.php">
                        <i class="nav-icon fa fa-calendar fa-fw"></i> Calendar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa fa-history fa-fw"></i> News</a>
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
                <?php echo "<a href='Teams.php?id=$id'>$name</a>";?>
            </li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <table class="table">
                    <?php echo '<p><h3 style="font-family: CoreUI-Icons-Linear-Free">Teams from '.$name.'</h3></p>';?>
                    <thead>
                    <tr>
                        <th scope="col">Logo</th>
                        <th scope="col">Name</th>
                        <th scope="col">Number of visit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($teams as $team) {
                        echo '
                            <tr>
                                  <td><img src="'.$team->getPathLogo().'"></td>
                                  <td><a href="Teams.php?id='.$id.'">'.$team->getName().'</a></td>
                                  <td>'.$team->getNbVisit().'</td>
                            </tr>';
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