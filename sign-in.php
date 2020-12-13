<?php
session_start();
if(isset($_SESSION['username'])) {
    header("Location: home.php");
    }
?>
<?php include 'config.php' ?>
<?php include 'sign-in-submit.php' ?>
<!DOCTYPE html>
<html>
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
    <link rel="icon" href="images_logo/background/logo_tdtu.png" type="image/icon type">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Sign in</title>
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
    <div class="container-fluid" onclick="closeNav()">
        <div class="sign_title w-100 mt-5">

            <div class="signin-form border m-auto">
                <h2 class="mb-4"> Sign in</h2>
                <form class="w-100" method="post" action="./sign-in-submit.php">
                    <div class="form-group">
                        <label for="inputUsername" class="">Username</label>
                        <div class="">
                            <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Username">
                        </div>
                    </div>
                    <div class="">
                        <label for="inputPassword" class="">Password</label>
                        <div class="">
                            <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
                        </div>
                        <?php
                        if(!empty($_SESSION['error'])) {
                            echo "<div class='error signin-error text-danger'>".$_SESSION['error']."</div>";
                            $_SESSION['error'] = "";
                        }
                        ?>
                    </div>
                    <div class="">
                        <div class="checkbox">
                            <div class="form-check">
                                <input class="my-auto" type="checkbox" id="gridCheck1">
                                <label class="form-check-label ml-3 my-auto" for="gridCheck1">
                                    Remember me
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="signin-button">
                        <div class="signin-button-item">
                            <button type="submit" name="submit" class="btn signin-btn btn-primary">Sign in</button>
                        </div>
                        <div class="create-account" style="font-weight: 400">Don't have one? <a href="./register.php">Create account</a></div>
                    </div>
                </form>

            </div>
            <div class="forget-pass mt-3" style="text-align: center"><a class="text-dark" href="./request-reset-password.php"><i>Forget password</i></a></div>
        </div>
    </div>
</body>
</html>