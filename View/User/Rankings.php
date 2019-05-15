<?php
require_once "../../Model/Team.php";
require_once "../../Model/Tournament.php";
require_once "../../Controller/controller-Global.php";
require_once "../../Controller/controller-Planning.php";
require_once "../../Model/Day.php";

if(isset($_GET["id"])) {
    $tournamentId = $_GET["id"];
    $order = "Score";
    if(isset($_POST["order"])){
        $order = $_POST["order"];
    }
    $rankings = getRankingsTournament($tournamentId, $order);
    $tournament = getTournamentById($tournamentId);
    $nbDays = getNbPlayedDays($tournamentId);
    $tournamentName = $tournament->getName();
    if (isset($_GET["day"])){
        $rankings = $rankings[$_GET["day"]];
    }
    else{
        $rankings = $rankings[$nbDays];
    }
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
    <h1 class="nav navbar-nav ml-auto">Tournament Management System</h1>
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
                <li class="nav-divider"></li>
                <li class="nav-title">Dashboard</li>
                <li class="nav-item">
                    <?php echo '<a class="nav-link" href="Tournament.php?id='.$tournamentId.'">
                    <i class="nav-icon fa fa-users fa-fw"></i> Teams</a>'; ?>
                </li>
                <li class="nav-item nav-dropdown">
                    <?php echo '<a class="nav-link nav-dropdown-toggle" href="Rankings.php?id='.$tournamentId.'">
                    <i class="nav-icon fa fa-eye fa-fw"></i> Rankings</a>';
                    ?>
                    <ul class="nav-dropdown-items">
                        <?php
                        echo '
                            <li class="nav-item">
                                <a class="nav-link" href="Rankings.php?id='.$tournamentId.'">Last Day</a>
                            </li>';
                        for ($i = $nbDays-1; $i >= 1; $i--){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link" href="Rankings.php?id='.$tournamentId.'&day='.$i.'">Day '.$i.'</a>
                            </li>';
                        }
                        ?>
                    </ul>
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
                <?php echo "<a href='Rankings.php?id=$tournamentId'>Rankings</a>";?>
            </li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col">
                        <?php
                        echo '<h3>Rankings from '.$tournamentName.'</h3>';
                        if(isset($_GET["day"])){
                            echo '<h4 class="">Day '.$_GET["day"].' out of '.$nbDays.' ordered by '.$order.'</h4>';
                        }
                        else{
                            echo '<h4>Last played day ordered by '.$order.'</h4>';
                            echo "<p><a class='btn btn-primary btn-sm' href=\"../../Controller/controller-Planning.php?func=exportRanking&id=".$tournamentId."&name=".$tournamentName."\" role='button'>Export</a></p>";
                        }
                        ?>
                    </div>
                    <div class="col">
                        <form method="post">
                            <h5>Order by: </h5>
                            <select title="order" name="order">
                                <option>Score</option>
                                <option>Goal Scored</option>
                                <option>Goal Taken</option>
                                <option>Goal Difference</option>
                                <option>Win</option>
                                <option>Draw</option>
                                <option>Lost</option>
                            </select>
                            <button type="submit">Validate</button>
                        </form>
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Rank</th>
                        <th scope="col">Team Name</th>
                        <th scope="col">Score</th>
                        <th scope="col">Goal scored</th>
                        <th scope="col">Goal taken</th>
                        <th scope="col">Goal difference</th>
                        <th scope="col">Win</th>
                        <th scope="col">Draw</th>
                        <th scope="col">Lost</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    foreach ($rankings as $team => $rank) {
                        $difference = $rank["goalScored"] - $rank["goalTaken"];
                        echo "<tr>
                                  <td>".$i."</td>
                                  <td>".$team."</td>
                                  <td>".$rank["score"]."</td>
                                  <td>".$rank["goalScored"]."</td>
                                  <td>".$rank["goalTaken"]."</td>
                                  <td>".$difference."</td>
                                  <td>".$rank["win"]."</td>
                                  <td>".$rank["draw"]."</td>
                                  <td>".$rank["lost"]."</td>
                              </tr>";
                        $i++;
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
<script src="../template/jquery/jquery.min.js"></script>
<script src="../template/@coreui/coreui/coreui.min.js"></script>
</body>
</html>