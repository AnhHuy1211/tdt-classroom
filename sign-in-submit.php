<?php
    include_once 'config.php';
    $conn = openDB();
    $errors = array();

    if(isset($_POST['submit'])){
        if(isset($_POST['username']) && isset($_POST['password'])){
            session_start();
            if(empty($username)) {
                $_SESSION['error'] = 'Invalid username';
                header('Location: ./sign-in.php');
            }
            
            $username = $_POST['username'];
            $password = md5($_POST['password']);

            if(!empty($username) && !empty($password)){

                $sql = "SELECT * FROM users_list WHERE username='$username' AND password='$password'";
                $user = mysqli_query($conn,$sql);
                
                if(mysqli_num_rows($user) == 0){
                    $_SESSION['error'] = 'Wrong username or password';

                }else if(mysqli_num_rows($user) > 0){

                    while($row = $user -> fetch_assoc()){
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['firstname'] = $row['firstname'];
                        $_SESSION['lastname'] = $row['lastname'];
                        $_SESSION['career'] = $row['career'];
                        $_SESSION['email'] = $row['email'];
                    }

                }
            }      
        }
        header("Location: ./home.php");
    }



?>