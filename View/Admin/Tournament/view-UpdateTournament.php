<?php
require_once "../../../Controller/controller-Global.php";
require_once "../../../Controller/controller-Tournament.php";

if(!isIdentified()){
    redirect("../../index.php?error=access_denied");
}
$id = $_GET['id'];
$tournament = getTournamentById($id);
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
    <meta name="description" content="New Admin">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>Update Tournament</title>
    <!-- Main style and icons for this application-->
    <link rel="shortcut icon" href="../../template/img/favicon.ico">
    <link rel="stylesheet" href="../../template/css/style.css">
    <link rel="stylesheet" href="../../template/@coreui/icons/css/coreui-icons.min.css">
    <link rel="stylesheet" href="../../template/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../template/simple-line-icons/css/simple-line-icons.css">
</head>
<body class="app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mx-4">
                <div class="card-body p-4">
                    <h1>Update</h1>
                    <p class="text-muted">Edit a tournament</p>
                    <?php echo "<form action=\"../../../Controller/controller-Tournament.php?func=editTournament&id=".$id."\" method='post'>"; ?>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-trophy"></i>
                            </span>
                            </div>
                           <?php echo "<input required class='form-control' type='text' name='tournament_name' value=".$tournament->getName().">"; ?>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-organization"></i>
                            </span>
                            </div>
                            <?php echo "<input required class='form-control' type='number' step='1' name='nb_team' value=".$tournament->getNbTeam().">"; ?>
                        </div>
                        <?php
                        if(isset($_GET['error'])){
                            if($_GET['error'] == "field_missing") {
                                echo "<div class='alert alert-danger' role='alert'>Fill all the fields !</div>";
                            }
                            if($_GET['error'] == "number_invalid") {
                                echo "<div class='alert alert-danger' role='alert'>Enter a valid number of teams (>0) !</div>";
                            }
                            if($_GET['error'] == "teams_already_created") {
                                echo "<div class='alert alert-danger' role='alert'>You need to delete teams before !</div>";
                            }
                            if($_GET['error'] == "days_already_generated") {
                                echo "<div class='alert alert-danger' role='alert'>Days are already generated, you can't change the number of teams !</div>";
                            }
                        }
                        ?>
                        <div class="row">
                            <div class="col-6">
                                <a href="../view-IndexAdmin.php"><button class="btn btn-danger px-4" type="button"><i class="fa fa-arrow-left"></i> Cancel</button></a>
                            </div>
                            <div class="col-6 text-right">
                                <input class="btn btn-primary px-4" type="submit" value="Update Tournament"/>
                            </div>
                        </div>
                    <?php echo "</form>"; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CoreUI and necessary plugins-->
<script src="../../template/jquery/jquery.min.js"></script>
<script src="../../template/@coreui/coreui/coreui.min.js"></script>
</body>
</html>