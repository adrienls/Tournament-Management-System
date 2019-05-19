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
    <link rel="shortcut icon" href="vendors/img/favicon.ico">
    <link rel="stylesheet" href="vendors/css/style.css">
    <link rel="stylesheet" href="vendors/@coreui/icons/css/coreui-icons.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show sidebar-minimized brand-minimized">
<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="index.php">
        <img class="navbar-brand-full" src="vendors/img/brand/logo.svg" width="89" height="25" alt="CoreUI Logo">
        <img class="navbar-brand-minimized" src="vendors/img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo">
    </a>
    <h1 class="nav navbar-nav ml-auto">Tournament Management System</h1>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" href="Admin/view-Login.php" role="button">
                <i class="cui-dashboard btn-lg"> Admin</i>
            </a>
        </li>
    </ul>
</header>
<div class="app-body">
    <div class="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav justify-content-center">
                <li class="nav-title">Please select a tournament first</li>
            </ul>
        </nav>
        <button  class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>
    <main class="main">
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="dropdown-divider"></div>
                <div class="row">
                    <?php
                    require_once "../Model/Tournament.php";
                    $color = array("bg-primary", "bg-secondary", "bg-success", "bg-danger", "bg-warning", "bg-info", "bg-light");
                    $i = 0;
                    $tournaments = getTournamentList();
                    foreach ($tournaments as $tournament){
                        echo '
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white '.$color[$i].'">
                                <div class="card-body">
                                   <a class="text-value text-body" href="User/Tournament.php?id='.$tournament->getId().'">'.$tournament->getName().'</a>
                                    <div>Number of team: '.$tournament->getNbTeam().'</div>
                                </div>
                            </div>
                        </div>
                        ';
                        $i = ($i === 6)? 0 : $i+1;
                    }?>
                </div>
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
<script src="vendors/jquery/jquery.min.js"></script>
<script src="vendors/@coreui/coreui/coreui.min.js"></script>
</body>
</html>