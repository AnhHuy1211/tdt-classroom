<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.9.0/css/all.css">
    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="images_logo/background/logo_tdtu.png" type="image/icon type">
    <title>TDTU's Classroom</title>
    <link rel="icon" href="images_logo/background/logo_tdtu.png" >
    <style>
        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }
    </style>
</head>
<body>
<div class="navigation">
    <div class="navbar navbar-light bg-light border-bottom w-100 normal-navbar">
        <div class="nav-header">
            <div class="show-sidebar btn border-0" onclick="openNav()"><i class="fal fa-bars fa-3x m-auto"></i></iv></div>
            <a class="navbar-brand mr-auto" href="index.php"><div class="brand h4 mt-1">Ton Duc Thang <small>Classroom</small></div></a>
        </div>
        <div class="nav-footer">
                <a class="nav-signin nav-link ml-auto text-primary font-weight-bold" href="sign-in.php">Sign in</a>
                <div class="nav-signin">or</div>
                <a class="nav-signin nav-link text-primary font-weight-bold" href="register.php">Create an account</a>
        </div>
    </div>
        <div class="sidebar navbar-collapse bg-light" id="navbarToggler">
            <div class="sidebar-header">
                <div class="signin"> <!-- Sau khi đã đăng nhập thì là class = "home" -->
                    <div class="signin-icon"> <!-- home-icon -->
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <a class="nav-link" href="sign-in.php">Sign In</a>
                </div>
            </div>
    </div>
</div>
<div class="background" style="background-image: url('images_logo/background/tdtu_international.jpg')" onclick="closeNav()">
    <div class="description h1 bg-dark text-light p-5 h-25">TDTU's Classroom Management System</div>
    <div class="mobile-signin mt-auto mb-auto p-5">
        <div class="mobile-signin-item btn btn-primary btn-lg"><a class="text-light" href="sign-in.php">Sign in</a></div>
        <div class="mobile-signin-item h2 text-light"> or</div>
        <div class="mobile-signin-item btn btn-primary btn-lg"><a class="text-light" href="register.php">Create an account</a></div>
        <div class="mobile-signin-item h2 text-light">to get started</div>
    </div>

</div>
</body>

</html>
