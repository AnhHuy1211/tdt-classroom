<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<?php
    include_once("config.php");
    include_once("send_mail.php");

    $conn = openDB();

    date_default_timezone_set("Asia/Bangkok");
    $now = date("Y-m-d h:i:s");

    $expired_time = $_SESSION['expired_time'];
    echo "Curren time now: $now<br>";
    echo "Reset time will expired at : $expired_time<br>";

    if($now > $_SESSION['expired_time']){
        die("Sorry! Your link is expired");
    }

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
            exit("Password updated");
        }else{
            exit("Something went wrong");
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            <?php include 'style.css'; ?>
        </style> 
    </head>

    <body>
        <div class="forget_form">
            <div id="header">
                <h2 id="header_reset">Reset password for TDTU Classroom account</h2>
            </div>
       

            <form method="POST" class="forget_input"> 
                <div class="input_area">
                    <span id="instruction"><p>Please enter new password for your account.</p></span>
                    <span><input type="password" name="password" autocomplet="off" placeholder="New password"></span>
                </div>  

                <div class="buttons_area">
                    <div class="buttons">
                        <span><button type="submit" value="update_password"class="btn btn-primary">Reset</button></span>
                        <span><button type="button" class="btn btn-light"><a href="sign-in.php">Cancel</a></button></span>
                    </div>
                </div>
            </form>

        </div>  
    </body>

    
</html>