<?php
include_once "./config.php";
session_start();
$conn = openDB();

$newClassname = $_POST['content'];
$classCode = $_SESSION['class_code'];

if($newClassname != "") {
    $sql = "UPDATE course_list SET course_name = '$newClassname' WHERE class_code = '$classCode'";
    mysqli_query($conn, $sql);

    $sql = "SELECT * FROM users_list";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while ($row = $result ->fetch_assoc()) {
            $username = "users__".$row['username'];
            $sql = "UPDATE $username SET course_name = '$newClassname' WHERE class_code = '$classCode'";
            mysqli_query($conn, $sql);
        }
    }
}

closeDB($conn);

