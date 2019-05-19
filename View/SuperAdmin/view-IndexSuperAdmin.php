<?php
require_once "../../Controller/controller-Global.php";
require_once "../../Controller/controller-Admin.php";

if(isIdentified()){
    if($_SESSION['username']==="admin") {
        $admins = getAdminList();
        /*
        if(isset($_GET['success'])){
            if($_GET['success'] == "new") {echo "<br><b style='color:green;'>Admin created !</b><br>";}
            if($_GET['success'] == "update") {echo "<br><b style='color:green;'>Admin updated !</b><br>";}
            if($_GET['success'] == "delete") {echo "<br><b style='color:green;'>Admin erased !</b><br>";}
        }
        echo "<br><a href='../Admin/view-IndexAdmin.php'>Back</a>";*/
    }
    else {
        redirect("../Admin/view-IndexAdmin.php");
    }
}
else {
    redirect("../Admin/view-Login.php?error");
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
    <link rel="shortcut icon" href="../vendors/img/favicon.ico">
    <link rel="stylesheet" href="../vendors/css/style.css">
    <link rel="stylesheet" href="../vendors/@coreui/icons/css/coreui-icons.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show sidebar-minimized brand-minimized">
<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="../index.php">
        <img class="navbar-brand-full" src="../vendors/img/brand/logo.svg" width="89" height="25" alt="CoreUI Logo">
        <img class="navbar-brand-minimized" src="../vendors/img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo">
    </a>
    <h1 class="nav navbar-nav ml-auto">Tournament Management System</h1>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" href="../../Controller/controller-Connect.php?func=logout" role="button">
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
                        echo '<p><h3>Admin Management</h3></p>';
                        echo '<p><a class="btn btn-primary" href="view-CreateAdmin.php" role="button">New Admin</a></p>';
                        ?>
                    </div>
                </div>
                <table class="table">
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
                <a class="btn btn-dark" href="../Admin/view-IndexAdmin.php" role="button">Back</a>
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
<script src="../vendors/jquery/jquery.min.js"></script>
<script src="../vendors/@coreui/coreui/coreui.min.js"></script>
</body>
</html>