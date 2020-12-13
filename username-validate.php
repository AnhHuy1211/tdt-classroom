<?php
include_once './config.php';
$conn = openDB();

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_REQUEST["term"])){

    $sql = "SELECT username FROM users_list WHERE username LIKE ?";

    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_term);

        $param_term = $_REQUEST["term"] . '%';

        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) > 0){

                while($row = $result->fetch_assoc()){
                    if($row['username'] == $_REQUEST['term']) {
                        echo $row['username'];
                    }
                }
            } else{
                echo "";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>