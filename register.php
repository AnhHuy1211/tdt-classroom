<?php
session_start();
if(isset($_SESSION['username'])) {
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Create account</title>
        <link rel="icon" href="./images_logo/background/logo_tdtu.png" type="image/icon type">
        <style type="text/css">
            <?php include 'style.css'; ?>
        </style> 
        
        <?php require('config.php'); ?>
        <?php require 'register-submit.php';?>
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
        <style>
            html, body {
                height: 100%;
            }
        </style>
        <script type="text/javascript">


        </script>
    </head>

    <body>
    <div class="navigation">
        <div class="navbar navbar-light bg-light border-bottom w-100 normal-navbar">
            <div class="nav-header">
                <div class="show-sidebar btn border-0" onclick="openNav()"><i class="fal fa-bars fa-3x m-auto"></i></iv></div>
                <a class="navbar-brand mr-auto" href="index.php"><div class="brand h4 mt-1">Ton Duc Thang <small>Classroom</small></div></a>
            </div>
        </div>
        <div class="sidebar navbar-collapse bg-light" id="navbarToggler">
            <div class="sidebar-header">
                <div class="signin"> <!-- Sau khi đã đăng nhập thì là class = "home" -->
                    <div class="signin-icon"> <!-- home-icon -->
                        <i class="fas fa-home"></i>
                    </div>
                    <a class="nav-link pt-2 pb-2" href="index.php">Home</a>
                </div>
            </div>
        </div>
    </div>
        <div class="container-fluid" id="container_register" onclick="closeNav()" style="padding-bottom: 24px">
            <div class="register_area" >
                <div class = "header">
                    <h1 class="title">Sign up</h1>
                    <img id="img_title" src="images_logo/background/logo_tdtu.png" style="width: 20%; height: 20%">
                </div>

                <div class="input_area">
                    <form class="form" method="post" action="register-submit.php" autocomplete="off">
                        <div class="name">
                            <div class="fullname">
                                <div class="fullname-item">
                                    <label for="firstname">First name<span class="text-danger">*</span></label>
                                    <input id= "firstname" type="text" name="firstname" placeholder="First name" onkeyup="checkEmptyName()" required>
                                </div>
                                <div class="fullname-item">
                                    <label for="lastname">Last name<span class="text-danger">*</span></label>
                                    <input id= "lastname" type="text" name="lastname" placeholder="Last name" onkeyup="checkEmptyName()" required>
                                </div>
                            </div>
                            <div class="error name-error text-danger" style="display: none"></div>
                        </div>
                        <div class="email">
                            <label for="email">E-mail<span class="text-danger">*</span></label>
                            <input id="email" type="email" name="email" placeholder="name@gmail.com" onkeyup="checkEmailExistence(true)" required>
                            <div class="error email-error text-danger" style="display: none"></div>
                        </div>
                        <div class="user_name">
                            <label for="username">Username<span class="text-danger">*</span></label>
                            <input id="username" type="text" name="username" placeholder="Username" onkeyup="checkUserExistence(true)" required>
                            <span class="username_demand">
                                <small class="register-description">Username contains 3-16 characters, starts and ends with a letter.
                                    No special characters are allowed except a single " _ " or dot</small>
                            </span>
                            <div class="error username-error text-danger" style="display: none"></div>
                        </div>
                       <div class="date_phone">
                           <div class="phone_number">
                               <label for="phone">Phone number</label>
                               <input id="phone" type="text" name="phone_number" placeholder="Phone number">
                           </div>
                            <div class="date_of_birth">
                                <label for="date_of_birth">Date of birth</label>
                                <input type="date" id="date_of_birth" name="date_of_birth">
                            </div>

                       </div>

                        <div class="choose_career">
                            <label for="career">Choose your career<span class="text-danger">*</span></label>
                            <select name="career" id="career">
                                <option value="teacher">Teacher</option>
                                <option value="student">Student</option>
                            </select>
                        </div>

                        <div class="password_confirm mt-0">
                            <div class="password_confirm">
                                <label for="password">Choose a password<span class="text-danger">*</span></label>
                                <input type="password" id="password" name="password" placeholder="Password" onkeyup="checkPasswordValidate()" required>
                                <div class="password_demand">
                                    <small class="register-description pt-1">Password must contain at least 8 characters</small>
                                </div>
                                <div class="error password-error text-danger" style="display: none"></div>
                            </div>
                            <div class="password_confirm">
                                <label for="confirm">Confirm your password<span class="text-danger">*</span></label>
                                <input type="password" id ="confirm" name="confirm" placeholder="Confirm password" onkeyup="checkPasswordConfirm()" required>
                                <div class="error confirm-error text-danger" style="display: none"></div>
                            </div>
                        </div>


                        <div class="buttons">
                            <div class="login_button ml-0 pt-2" style="cursor: context-menu">
                                Already have an account?
                                <a class="text-dark" href="sign-in.php" style="cursor: pointer"> Sign in</a>
                            </div>
                            <div class="next_button mr-0 w-25">
                                <button class="btn btn-primary w-100" id="sign-up-btn" type="submit" name="submit" onmouseenter="enableSubmitButton()" disabled>Sign up</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div style="line-height: 40px; visibility: hidden">This div space adds more space for the footer</div>
        </div>
    </body>
</html>