<?php
require_once "../../../Controller/controller-Global.php";
require_once "../../../Controller/controller-Team.php";

if(!isIdentified()){
    redirect("../../index.php?error=access_denied");
}

$id_team = $_GET['id'];
$info = getTeamById($id_team);
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
    <title>Update Team</title>
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
                    <p class="text-muted">Edit a team</p>
                    <?php echo "<form action=\"../../../Controller/controller-Team.php?func=editTeam&id=".$id_team."&name=".$_GET['name']."\" method='post' enctype='multipart/form-data'>"; ?>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-badge"></i>
                            </span>
                            </div>
                            <?php echo "<input required class='form-control' type='text' name='name' value=".$info->getName().">"; ?>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="icon-picture"></i>
                                        </span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputFile" name='logo' size='100000'>
                                <label class="custom-file-label" for="inputFile">Choose Logo</label>
                            </div>
                        </div>
                        <?php
                        if(isset($_GET['error'])){
                            if($_GET['error'] == "need_name") {
                                echo "<div class='alert alert-danger' role='alert'>Fill at least the name !</div>";
                            }
                            if($_GET['error'] == "name_used") {
                                echo "<div class='alert alert-danger' role='alert'>Name already used !</div>";
                            }
                            if($_GET['error'] == "logo_invalid") {
                                echo "<div class='alert alert-danger' role='alert'>Logo is too big !</div>";
                            }
                        }
                        ?>
                        <div class="row">
                            <div class="col-6">
                                <?php echo "<a href=\"../Tournament/view-IndexTournament.php?id=".$_GET['tournament_id']."&name=".$_GET['name']."\"><button class=\"btn btn-danger px-4\" type=\"button\"><i class=\"fa fa-arrow-left\"></i> Cancel</button></a>"; ?>
                            </div>
                            <div class="col-6 text-right">
                                <input class="btn btn-primary px-4" type="submit" value="Add Team"/>
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