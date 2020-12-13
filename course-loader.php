<?php
include_once 'send_mail.php';
function generateRandomString($length = 7) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
<?php
/*them lop hoc vao database của nguoi dung*/
    session_start();
    include_once './config.php';
    $conn = openDB();
    $classCode = generateRandomString();
    if (!empty($_SESSION)) {
        $username = "users__" . $_SESSION['username'];
        $firstname = $_SESSION['firstname'];
        $lastname = $_SESSION['lastname'];
        $email = $_SESSION['email'];
        $user = $_SESSION['username'];
        $role = $_SESSION['career'];
    }
    date_default_timezone_set('Asia/Bangkok');
    $date = date('m-d-Y g:i:sA');

    if(!empty($_GET['class-code']) && !empty($_GET['join-request'])) {
        $joinCode = $_GET['class-code'];
        $sql = "SELECT * FROM `course_list` WHERE class_code = '$joinCode'";
        $loadClass = mysqli_query($conn, $sql);

        if (mysqli_num_rows($loadClass) > 0) {
            while ($row = $loadClass->fetch_assoc()) {
                $classCode = $row['class_code'];
                $className = $row['course_name'];
                $teacherName = $row['teacher_name'];
            }
            //them class vao database cua sv
            $sql = "INSERT INTO $username (class_code, course_name, teacher_name, role) VALUES('$classCode', '$className', '$teacherName', '".$_GET['student-role']."')";
            mysqli_query($conn, $sql) or die("FAILED TO ADD USER 1! $conn->error");

            //them sv vao database lop hoc
            $className = "courses__".$joinCode;
            $sql = "INSERT INTO $className (firstname, lastname, email, username, role, date_join) VALUES('".$_GET['student-firstname'] . "', '". $_GET['student-lastname']."', '".$_GET['student-email']."', '".$_GET['student-username']."', '".$_GET['student-role']."', '$date')";
            mysqli_query($conn, $sql) or die("FAILED TO ADD USER 2! $conn->error");
            closeDB($conn);
            send_mail($_GET['join-request'], $_GET['student-email'], $className);
        }
    }

    if(!empty($_POST['class-name'])) {
        $className = $_POST['class-name'];

        $teacherName =$_SESSION['lastname']." ".$_SESSION['firstname'];

        //Insert vao danh sach lop rieng cua teacher
        $sql = "INSERT INTO $username (class_code, course_name, teacher_name, role) VALUES('$classCode', '$className', '$teacherName', '$role')";
        mysqli_query($conn, $sql) or die("FAILED 1 $conn->error");

        //Insert vao danh sach lop chung
        $sql = "INSERT INTO course_list (class_code, course_name, teacher_name, date_created) VALUES('$classCode', '$className', '$teacherName', '$date')";
        mysqli_query($conn, $sql) or die('FAILED 2');

        //tao database lop hoc
        $courseLoad = "courses__".$classCode;

        $sql = "CREATE TABLE `$courseLoad` (
    `firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
    `lastname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
    `role` varchar (11) COLLATE utf8_unicode_ci NOT NULL,
    `date_join` varchar (50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
        mysqli_query($conn, $sql) or die("FAILED CREATE TABLE! $conn->error");

        //them nguoi tao vao database lop hoc vua tao
        $sql = "INSERT INTO $courseLoad (firstname, lastname, email, username, role, date_join) VALUES('$firstname', '$lastname', '$email', '$user', '$role', '$date')";

        mysqli_query($conn, $sql) or die("FAILED TO ADD USER 3! $conn->error");
        closeDB($conn);
        header("Location: ./home.php");
    }

    if(!empty($_GET['invite-code'])) {
        $courseLoad = "courses__".$_GET['invite-code'];
        $username = "";
        $sql = "SELECT * FROM users_list WHERE email ='".$_GET['invite-email']."'";
        $usernameLoad = mysqli_query($conn, $sql);
        if ($usernameLoad -> num_rows > 0) {
            while ($row = $usernameLoad ->fetch_assoc()) {
                $username = "users__".$row['username'];
                $sql = "INSERT INTO $username (class_code, course_name, teacher_name, role) VALUES ('".$_GET['invite-code']."', '".$_GET['invite-class']."', '".$_GET['invite-name']."','".$_GET['invite-role']."')";
                mysqli_query($conn, $sql) or die($conn);

                $sql = "INSERT INTO $courseLoad (firstname, lastname, email, username, role, date_join) VALUES ('".$row['firstname']."', '".$row['lastname']."', '".$row['email']."', '".$row['username']."', '".$_GET['invite-role']."', '$date')";
                mysqli_query($conn, $sql) or die($conn);
            }
        }
        closeDB($conn);
        ?>
        <script type="text/javascript">
            window.close();
        </script>
        <?php
    }


?>


