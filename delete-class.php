<?php
session_start();
include_once './config.php';
$conn = openDB();


// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(!empty($_POST['delete-code'])){

    $sql = "DELETE FROM course_list WHERE class_code = '".$_POST['delete-code']."'";
    mysqli_query($conn,$sql) or die("DELETE FAILED:");

    $sql = "DROP TABLE courses__".$_POST['delete-code'];
    mysqli_query($conn, $sql);

    $sql = "SELECT * FROM users_list";
    $deleteResult = mysqli_query($conn, $sql);

    while ($row = $deleteResult->fetch_assoc()) {
        $sql = "DELETE FROM users__".$row['username']." WHERE class_code = '".$_POST['delete-code']."'";
        mysqli_query($conn,$sql) or die("DELETE FAILED:");
    }
    closeDB($conn);
    header("Location: ./home.php");

} else if(isset($_POST['student-name'])) {
    if(!empty($_POST['student-name'])) {
        foreach ($_POST['student-name'] as $user) {
            $username = "$user";
            $classCode = $_SESSION['class_code'];
            $sql = "DELETE FROM users__$username WHERE class_code ='$classCode'";
            mysqli_query($conn, $sql) or die($conn->error);

            $sql = "DELETE FROM courses__$classCode WHERE username = '" . $username . "'";
            mysqli_query($conn, $sql) or die("DELETE FAILED2:");
        }
        closeDB($conn);
        header("Location: ./sort-all-name.php");
    }
} else {
    header("Location: ./sort-all-name.php?r=3");
}


?>