<?php
    include_once("config.php");
    include_once("send_mail.php");

    $conn = openDB();

    if(!isset($_GET['code'])){
        exit("Can't find page");
    }

    $code = $_GET['code'];

    $getEmailQuery = mysqli_query($conn, "SELECT email FROM reset_password WHERE code='$code'" );
   
    if(mysqli_num_rows($getEmailQuery) == 0){
        exit("Can't find page");
    }

    if(isset($_POST['password'])){
        $password = $_POST['password'];
        $password = md5($password);

        $row = mysqli_fetch_array($getEmailQuery);
        $email = $row['email'];

        $query = mysqli_query($conn, "UPDATE users_list SET password='$password' WHERE email='$email'");
        
        if($query){
            $query = mysqli_query($conn,"DELETE FROM reset_password WHERE code='$code'");
            header("Location: ./sign-in.php");
        }
    }

?>

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
        <title>Reset password</title>
        <style>
            .password_confirm input {
                border-radius: 5px;
                padding: 5px;
                border: 2px solid #f0f0f0;
            }
        </style>
    </head>

    <body>
    <div class="forget_form" style="border-radius: .5rem; padding: 1.5rem">
        <form method="POST" class="forget_input">
            <div id="header">
                <h2>Reset password</h2>
            </div>
            <div class="password_confirm mt-3">
                <div class="password_confirm" style="display: flex; flex-direction: column">
                    <label for="password" class="font-weight-bold">Enter your new password</label>
                    <input type="password" id="password" name="password" placeholder="Password" onkeyup="checkResetPasswordValidate()" required>
                    <div class="password_demand">
                        <small class="register-description pt-1">Password must contain at least 8 characters</small>
                    </div>
                    <div class="error password-error text-danger" style="display: none"></div>
                </div>
                <div class="password_confirm mt-3" style="display: flex; flex-direction: column">
                    <label for="confirm" class="font-weight-bold">Confirm your password<span class="text-danger">*</span></label>
                    <input type="password" id="confirm" name="confirm" placeholder="Confirm password" onkeyup="checkResetPasswordConfirm()" required>
                    <div class="error confirm-error text-danger" style="display: none"></div>
                </div>
            </div>

            <div class="buttons_area mt-3">
                <button type="submit" class="reset-btn btn btn-primary" disabled>Reset</button>
                <button type="button" class="btn mr-3" onclick="window.location.href='./sign-in.php'">Cancel</button>
            </div>
        </form>
    </div>
    </body>

    
</html>