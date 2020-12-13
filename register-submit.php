<?php
    include_once './config.php';
    $errors = array();
    $conn= openDB();
    if(isset($_POST['submit'])){
        

        if(isset($_POST['firstname']) && isset($_POST['lastname'])
            && isset($_POST['email']) && isset($_POST['username'])
            && isset($_POST['password']) && isset($_POST['confirm'])){

            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $date_of_birth = $_POST['date_of_birth'];
            $phone_number = $_POST['phone_number'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm = $_POST['confirm'];
            $career = $_POST['career'];
            if(empty($email)){
              array_push($errors, 'Email is required');
            }
            
            if(!empty($firstname) && !empty($lastname) && !empty($email)
            && !empty($username) && !empty($password) && !empty($confirm)){ 
                
                if($password != $confirm){
                    die();
                }else{
                    $sql = "SELECT * FROM user_list WHERE username= '$username'";
                    $num = mysqli_query($conn, $sql);
                    $password = md5($password);

                    $sql = "INSERT INTO users_list (firstname,lastname,date_of_birth,phone,email,username,password,career) VALUES('$firstname','$lastname','$date_of_birth','$phone_number','$email','$username','$password','$career')";
                    mysqli_query($conn, $sql);
            
                    /* Create database table for each user*/
                    //  mysqli_select_db("database",$conn);
                    $username = "users__$username";
                    $sql = "CREATE TABLE $username(
                        class_code varchar (7) COLLATE utf8_unicode_ci NOT NULL, /*code de join class*/
                        course_name LONGTEXT COLLATE utf8_unicode_ci NOT NULL,
                        teacher_name varchar(100)COLLATE utf8_unicode_ci NOT NULL,
                        role varchar(10) COLLATE utf8_unicode_ci NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

                    mysqli_query($conn,$sql) or die("Create failed: $sql");
                    
                    closeDB($conn);

                    header('Location: ./sign-in.php');
                    
                }

            }
        }
    }
?>