<?php
    require 'PHPMailer/source/PHPMailerAutoload.php';
     include_once 'config.php';

     if(!empty($_POST['invite-request'])) {
         send_mail($_POST['invite-request'], '', '');
     }

     if(!empty(($_POST['join-request']))) {
         send_mail($_POST['join-request'], '', '');
     }

     if(!empty($_POST['class-code'])) {
         send_mail(3, '', '');
     }

     function send_mail($purpose, $specific, $object){
        /*
            $purpose = 1 => Reset mail
            $purpose = 2 => Gui mail cho sinh vien
         */
         
        $conn = openDB();
         mysqli_set_charset($conn, 'UTF8');

            if($purpose == 1){
                //date_default_timezone_set("Asia/Bangkok");
                //$time = date('Y-m-d h:i:s', time() + (60 * 60));

                //$_SESSION['expired_time'] = $time;
                if(isset($_POST['email'])) {
                    $email_to = $_POST['email'];
                    $code = uniqid(true);
                    $query = mysqli_query($conn, "INSERT INTO reset_password(code, email) VALUES('$code' , '$email_to') ");

                    if (!$query) {
                        exit("Error");
                    }

                    

                    // Instantiation and passing `true` enables exceptions
                    $mail = new PHPMailer;
                    try {
                        //Server settings
                        $mail->isSMTP();
                        $mail->CharSet = 'UTF-8';// Send using SMTP
                        $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
                        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                        $mail->Username = 'buingockhaitam01@gmail.com';                     // SMTP username
                        $mail->Password = 'tbgoodkid1707';                               // SMTP password
                        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                        //Recipients
                        $mail->setFrom('buingockhaitam01@gmail.com', 'TDTU Classroom Server');
                        $mail->addAddress("$email_to");     // Add a recipient
                        $mail->addReplyTo('no-reply@gmail.com', 'No Reply');

                        // Content
                        $url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/reset-password.php?code=$code";
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = 'Reset TDTU Classroom Password';
                        $mail->Body = "<h1>Need to reset your password ?</h1>
                                        Click <a href='$url'>this link </a> within the next hour to create a new password";
                        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                        $mail->send();
                        echo 'Password reset has been sent to your email';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
            }else if($purpose == 2) {
                    // Instantiation and passing `true` enables exceptions
                if(!empty($_POST)) {
                    $mail = new PHPMailer;
                    try {

                        //Server settings
                        $mail->isSMTP();
                        $mail->CharSet = 'UTF-8';// Send using SMTP
                        $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
                        $mail->SMTPAuth = true;                                  // Enable SMTP authentication
                        $mail->Username = 'nguyen.a.huy03217@gmail.com';                     // SMTP username
                        $mail->Password = 'Huy0913899182';                               // SMTP password
                        $mail->SMTPSecure = 'tls';
                        $mail->SMTPDebug = 0;
                        $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                        //Recipients
                        $mail->setFrom('admin_TDTU_Classroom@gmail.com', 'TDTU Classroom Server');
                        $mail->addAddress("" . $_POST['invite-email'] . "");     // Add a recipient
                        $mail->addReplyTo('no-reply@gmail.com', 'No Reply');

                        // Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = "Class invitation";
                        $user = "";
                        $sql = "SELECT * FROM users_list WHERE email ='" . $_POST['invite-email'] . "'";
                        $usernameLoad = mysqli_query($conn, $sql);
                        if ($usernameLoad->num_rows > 0) {
                            while ($row = $usernameLoad->fetch_assoc()) {
                                $user = $row['lastname'] . " " . $row['firstname'];
                            }
                            closeDB($conn);
                        }
                        session_start();
                        $mail->Body = "<h1>Hello, " . $user . "</h1>" . $_POST['invite-name']." (".$_SESSION['email'].") "." invited you to the class " . $_POST['invite-class'] . "
                                    <form method='get' action='http://" . str_replace(" ", "%20", $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"])) . "/course-loader.php'>
                                        <input id='invite-name' name='invite-name' value='" . $_POST['invite-name'] . "' style='display: none'>
                                        <input id='invite-role' name='invite-role' value='" . $_POST['invite-role'] . "' style='display: none'>
                                        <input id='invite-code' name='invite-code' value='" . $_POST['invite-code'] . "' style='display: none'>
                                        <input id='invite-class' name='invite-class' value='" . $_POST['invite-class'] . "' style='display: none'>
                                        <input id='invite-email' name='invite-email' value='" . $_POST['invite-email'] . "' style='display: none'>
                                        <button type='submit' style='
                                            color: #fff;
                                            background-color: #007bff;
                                            border-color: #007bff;
                                            padding: .375rem .75rem;
                                            font-size: 1rem;
                                            line-height: 1.5;
                                            border-radius: .25rem;
                                            font-weight: 400;
                                            text-align: center;
                                            white-space: nowrap;
                                            vertical-align: middle;
                                        
                                        '>Join</button>
                                    </form>";
                        $mail->AltBody = 'If you accept, your contact information will be shared with the class members and applications they authorize to use Classroom';

                        if($mail->send()) {
                            ?>
                            <script type="text/javascript">
                                window.location.href = './sort-all-name.php?r=1';
                            </script>
                            <?php
                        }

                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }

            } else if($purpose == 3) {  //join class request
                if (!empty($_POST['class-code'])) {
                    $mail = new PHPMailer;
                    $mail->CharSet = 'UTF-8';
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->SMTPAuth = true;                                  // Enable SMTP authentication
                    $mail->Username = 'nguyen.a.huy03217@gmail.com';                     // SMTP username
                    $mail->Password = 'Huy0913899182';                               // SMTP password
                    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port = 587;

                    try {
                        $class = "";
                        $courseName = "courses__".$_POST['class-code'];
                        $sql = "SELECT * FROM $courseName WHERE role = 'teacher'";
                        $teacherInfo = mysqli_query($conn, $sql);
                        if($teacherInfo -> num_rows > 0) {
                            session_start();
                            $_SESSION['student-email'] = $_POST['student-email'];
                            while ($row = $teacherInfo ->fetch_assoc()) {
                                //Recipients
                                $mail->setFrom("".$_POST['student-email']."", "".$_POST['student-lastname']." ".$_POST['student-firstname']."");
                                $mail->addAddress("" . $row['email'] . "");     // Add a recipient
                                $mail->addReplyTo('no-reply@gmail.com', 'No Reply');
                                $sql = "SELECT * FROM course_list WHERE class_code = '".$_POST['class-code']."'";
                                $className = mysqli_query($conn, $sql);
                                if($className -> num_rows > 0) {
                                    while ($name = $className -> fetch_assoc()) {
                                        $class = $name['course_name'];
                                    }
                                }
                                // Content
                                $mail->isHTML(true);                                  // Set email format to HTML
                                $mail->Subject = "Join class request";

                                $mail->Body = "<h1>Hello, " . $row['firstname'] . "</h1>" . $_POST['student-lastname']." ".$_POST['student-firstname']." (".$_POST['student-email'].") "." requested you to join " . $class . "
                                    <form method='get' action='http://" . str_replace(" ", "%20", $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"])) . "/course-loader.php'>
                                        <input  name='join-request' value='4' style='display: none'>
                                        <input  name='class-code' value='" . $_POST['class-code'] . "' style='display: none'>
                                        <input  name='student-firstname' value='" . $_POST['student-firstname'] . "' style='display: none'>
                                        <input  name='student-lastname' value='" . $_POST['student-lastname'] . "' style='display: none'>
                                        <input  name='student-email' value='" . $_POST['student-email'] . "' style='display: none'>
                                        <input  name='student-username' value='" . $_POST['student-username'] . "' style='display: none'>
                                        <input  name='student-role' value='student' style='display: none'>                                                                    
                                        <button type='submit' style='
                                            color: #fff;
                                            background-color: #007bff;
                                            border-color: #007bff;
                                            padding: .375rem .75rem;
                                            font-size: 1rem;
                                            line-height: 1.5;
                                            border-radius: .25rem;
                                            font-weight: 400;
                                            text-align: center;
                                            white-space: nowrap;
                                            vertical-align: middle;
                                            float: right;
                                            margin-top: 2rem;
                                            margin-right: 60%;
                                            cursor: pointer;                           
                                        '>Accept</button>
                                       
                                    </form>
                                    <form method='post' action='http://" . str_replace(" ", "%20", $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"])) . "/send_mail.php'>
                                    <input  name='join-request' value='5' style='display: none'>
                                    <input  name='student-email' value='" . $_POST['student-email'] . "' style='display: none'>
                                    <input  name='student-class' value=' " . $class . "' style='display: none'>
                                    <button type='submit' style='
                                            color: #fff;
                                            background-color: #292b2c;
                                            border-color: #292b2c;
                                            padding: .375rem .75rem;
                                            font-size: 1rem;
                                            line-height: 1.5;
                                            border-radius: .25rem;
                                            font-weight: 400;
                                            text-align: center;
                                            white-space: nowrap;
                                            vertical-align: middle;
                                            float:right;
                                            margin-top: 2rem;
                                            margin-right: 1.5rem;
                                            cursor: pointer;                                  
                                        '>Deny</button>
                                    </form>";

                                if($mail->send()) {
                                    ?>
                                    <script type="text/javascript">
                                        window.location.href= "./home.php?r=2";
                                    </script>
                                    <?php
                                }
                            }
                        }
                        //Server settings
                                                            // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                        header("./sort-all-name.php");
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
            } else if($purpose == 4){ //accepted join request
                if(isset($_POST)) {
                    // Instantiation and passing `true` enables exceptions
                    $mail = new PHPMailer;
                    try {
                        //Server settings
                        $mail->isSMTP();
                        $mail->CharSet = 'UTF-8';// Send using SMTP
                        $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
                        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                        $mail->Username = 'nguyen.a.huy03217@gmail.com';                     // SMTP username
                        $mail->Password = 'Huy0913899182';                               // SMTP password
                        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                        //Recipients
                        $mail->setFrom('admin_TDTU_Classroom@gmail.com', 'TDTU Classroom Server');
                        $mail->addAddress("$specific");     // Add a recipient
                        $mail->addReplyTo('no-reply@gmail.com', 'No Reply');

                        // Content

                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = 'Request approved';
                        $mail->Body = "<h4>Your previous request to join $object has been approved!</h4>";
                        $mail->AltBody = 'Keep up!';

                        if($mail->send()) {
                            ?>
                            <script type="text/javascript">
                                window.close();
                            </script>
                            <?php
                        }

                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
            } else if($purpose == 5){ //accepted join request
             if(isset($_POST)) {
                 // Instantiation and passing `true` enables exceptions
                 $mail = new PHPMailer;
                 try {
                     //Server settings
                     $mail->isSMTP();
                     $mail->CharSet = 'UTF-8';// Send using SMTP
                     $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
                     $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                     $mail->Username = 'nguyen.a.huy03217@gmail.com';                     // SMTP username
                     $mail->Password = 'Huy0913899182';                               // SMTP password
                     $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                     $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                     //Recipients
                     $mail->setFrom('admin_TDTU_Classroom@gmail.com', 'TDTU Classroom Server');
                     $mail->addAddress("".$_POST['student-email']."");     // Add a recipient
                     $mail->addReplyTo('no-reply@gmail.com', 'No Reply');

                     // Content

                     $mail->isHTML(true);                                  // Set email format to HTML
                     $mail->Subject = 'Request denied';
                     $mail->Body = "<h4>Your previous request to join ".$_POST['student-class']." has been denied</h4>";
                     $mail->AltBody = 'Sorry!';

                     if($mail->send()) {
                         ?>
                         <script type="text/javascript">
                             window.close();
                         </script>
                         <?php
                     }

                 } catch (Exception $e) {
                     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                 }
             }
         }
   }
?>
