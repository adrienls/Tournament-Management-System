<?php
require_once "../../Controller/controller-Global.php";

if(!isIdentified() || $_SESSION['username']!="admin"){
    redirect("../Admin/view-Login.php?error=access_denied");
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
    <meta name="description" content="New Admin">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>New Admin</title>
    <!-- Main style and icons for this application-->
    <link rel="shortcut icon" href="../vendors/img/favicon.ico">
    <link rel="stylesheet" href="../vendors/css/style.css">
    <link rel="stylesheet" href="../vendors/@coreui/icons/css/coreui-icons.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../vendors/simple-line-icons/css/simple-line-icons.css">
</head>
<body class="app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mx-4">
                <div class="card-body p-4">
                    <h1>Register</h1>
                    <p class="text-muted">Create a new admin</p>
                    <form action='../../Controller/controller-Admin.php?func=createAdmin' method='post'>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-user"></i>
                            </span>
                            </div>
                            <input required class="form-control" type="text" name="username" placeholder="Username">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-lock"></i>
                            </span>
                            </div>
                            <input required class="form-control" type="password" name="password" placeholder="Password">
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-lock"></i>
                            </span>
                            </div>
                            <input required class="form-control" type="password" name="confirmPassword" placeholder="Repeat password">
                        </div>
                        <?php
                        if(isset($_GET['error'])){
                            if($_GET['error'] == "mismatch"){
                                echo "<div class='alert alert-danger' role='alert'>Passwords do not match!</div>";
                            }
                            if($_GET['error'] == "identical"){
                                echo "<div class='alert alert-danger' role='alert'>Username and password need to be different!</div>";
                            }
                            if($_GET['error'] == "name_used"){
                                echo "<div class='alert alert-danger' role='alert'>Username already used!</div>";
                            }
                            if($_GET['error'] == "field_missing"){
                                echo "<div class='alert alert-danger' role='alert'>A field is missing!</div>";
                            }
                        }?>
                        <div class="row">
                            <div class="col-6">
                                <a href="../SuperAdmin/view-IndexSuperAdmin.php"><button class="btn btn-danger px-4" type="button"><i class="fa fa-arrow-left"></i> Cancel</button></a>
                            </div>
                            <div class="col-6 text-right">
                                <input class="btn btn-primary px-4" type="submit" value="Add Admin"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CoreUI and necessary plugins-->
<script src="../vendors/jquery/jquery.min.js"></script>
<script src="../vendors/@coreui/coreui/coreui.min.js"></script>
</body>
</html>