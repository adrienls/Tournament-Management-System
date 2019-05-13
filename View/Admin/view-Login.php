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
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>Admin Login</title>
    <!-- Main style and icons for this application-->
    <link rel="shortcut icon" href="../template/img/favicon.ico">
    <link rel="stylesheet" href="../template/css/style.css">
    <link rel="stylesheet" href="../template/@coreui/icons/css/coreui-icons.min.css">
    <link rel="stylesheet" href="../template/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../template/simple-line-icons/css/simple-line-icons.css">
</head>
<body class="app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <h1>Admin Login</h1>
                        <p class="text-muted">Sign In to your account</p>
                        <form action="../../Controller/controller-Connect.php?func=login" method="post">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="icon-user"></i>
                                </span>
                                </div>
                                <input required class="form-control" type="text" name="login" placeholder="Username">
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="icon-lock"></i>
                                </span>
                                </div>
                                <input required class="form-control" type="password" name="password" placeholder="Password">
                            </div>
                            <?php if(isset($_GET['error'])) {
                                echo "<div class='alert alert-danger' role='alert'>A field is invalid !</div>";
                            }?>
                            <div class="row">
                                <div class="col-6">
                                    <a href="../index.php"><button class="btn btn-danger px-4" type="button"><i class="fa fa-arrow-left"></i> Home page</button></a>
                                </div>
                                <div class="col-6 text-right">
                                    <input class="btn btn-primary px-4" type="submit" value="Login"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>