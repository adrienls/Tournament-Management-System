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
    <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons/css/coreui-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="js/simple-line-icons/css/simple-line-icons.css">
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src="img/brand/logo.svg" width="89" height="25" alt="CoreUI Logo">
        <img class="navbar-brand-minimized" src="img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo">
    </a>
    <h1 class="nav navbar-nav ml-auto" style="font-family: CoreUI-Icons-Linear-Free">Tournament Management System</h1>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" href="Admin/view-Login.php" role="button">
                <i class="cui-dashboard btn-lg"> Admin</i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>Settings</strong>
                </div>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-user"></i> Profile</a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-wrench"></i> Settings</a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-lock"></i> Logout</a>
            </div>
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
                    <a class="nav-link" href="index.html">
                        <i class="nav-icon fa fa-dashboard fa-fw"></i> Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa fa-eye fa-fw"></i> Rankings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon fa fa-calendar fa-fw"></i> Calendar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="base/cards.html">
                        <i class="nav-icon fa fa-users fa-fw"></i> Teams</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="base/carousel.html">
                        <i class="nav-icon fa fa-history fa-fw"></i> News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="base/collapse.html">
                        <i class="nav-icon fa fa-cog fa-fw"></i> History</a>
                </li>
            </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>
    <main class="main">
        <br/>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <p><h3 style="font-family: CoreUI-Icons-Linear-Free">Tournament List</h3></p>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Number of team</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    require_once "../Controller/controller-Tournament.php";
                    $tournaments = getTournamentList();
                    foreach ($tournaments as $tournament){
                        echo '
                        <tr>
                              <th scope="row">'.$tournament->getId().'</th>
                              <td><a href="#">'.$tournament->getName().'</a></td>
                              <td>'.$tournament->getNbTeam().'</td>
                        </tr>';
                    }?>
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
<script src="js/jquery/js/jquery.min.js"></script>
<script src="js/popper.js/js/popper.min.js"></script>
<script src="js/bootstrap/js/bootstrap.min.js"></script>
<script src="js/pace-progress/js/pace.min.js"></script>
<script src="js/perfect-scrollbar/js/perfect-scrollbar.min.js"></script>
<script src="js/@coreui/coreui/js/coreui.min.js"></script>
<!-- Plugins and scripts required by this view-->
<script src="js/chart.js/js/Chart.min.js"></script>
<script src="js/@coreui/coreui-plugin-chartjs-custom-tooltips/js/custom-tooltips.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>