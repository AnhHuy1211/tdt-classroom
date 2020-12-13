<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
include_once "./config.php";
$conn = openDB();
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_REQUEST["term"])){
    // Prepare a select statement
    $sql = "SELECT * FROM course_list WHERE course_name LIKE ?";

    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);

        // Set parameters
        $param_term = $_REQUEST["term"] . '%';

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<li class='list-group-item search-result-item'>"
                        ."<a class='text-dark' href='./content.php?class=".$row["class_code"]."'><span class='font-weight-bold'>".$row["course_name"]."</span><small class='mt-1'>".$row['teacher_name']."</small></a>
                        </li>";
                }
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }


}

// close connection
closeDB($conn);
?>