<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<?php
    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    include_once './config.php';
    $conn = openDB();
    if(isset($_POST['email'])){

        $email_to = $_POST['email'];

        $code = uniqid(true);
        $query = mysqli_query($conn, "INSERT INTO reset_password(code, email) VALUES('$code' , '$email_to') ");
        
        if(!$query){
            exit("Error");
        }

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username = 'nguyen.a.huy03217@gmail.com';                     // SMTP username
            $mail->Password = 'Huy0913899182';                               // SMTP password
            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('buingockhaitam01@gmail.com', 'TDTU Classroom Server');
            $mail->addAddress("$email_to");     // Add a recipient
            $mail->addReplyTo('no-reply@gmail.com', 'No Reply');

            // Content
            $url = "http://". $_SERVER["HTTP_HOST"]. dirname($_SERVER["PHP_SELF"]) . "/reset-password.php?code=$code";
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Reset TDTU Classroom Password';
            $mail->Body    = "<h1>Need to reset your password ?</h1>
                            Click <a href='$url'>this link </a> within the next hour to create a new password";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if($mail->send()) {
                ?>
            <script type="text/javascript">
                window.location("https://mail.google.com/");
            </script>

            <?php
            }

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        exit();
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
                <h2>Find your account</h2>
            </div>
       

            <form method="POST" class="forget_input"> 
                <div class="input_area">
                    <span id="instruction"><p>Please enter your email to search for your account.</p></span>
                    <span><input type="email" name="email" autocomplete="off" placeholder="Email"></span>
                </div>  

                <div class="buttons_area">
                    <div class="buttons">
                        <span><button type="submit" class="btn btn-primary">Search</button></span>
                        <span><button type="button" class="btn btn-light">Cancel</button></span>
                    </div>
                </div>
            </form>

        </div> 
    </body>

</html>