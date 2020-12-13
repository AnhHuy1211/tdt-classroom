<?php
include_once './config.php';
include_once './course-display.php';
    session_start();

    if(!isset($_SESSION['username'])) {
        header("Location: ./sign-in.php");
    }
    if(isset($_GET)){
        $username="users__".$_SESSION['username'];
        $classCode = $_GET['class'];
        $conn = openDB();

        $sql = "SELECT course_name FROM $username WHERE class_code = '$classCode'";
        $error =  mysqli_query($conn, $sql);
        $row_error = $error->fetch_assoc();

        $sql = "SELECT course_name FROM course_list WHERE class_code = '$classCode'";
        $error =  mysqli_query($conn, $sql);
        $row_notfound = $error->fetch_assoc();

         if (!$row_notfound) {
            echo "<link rel='icon' href='images_logo/background/logo_tdtu.png' type='image/icon type'>";
            echo "<title>404 Page Not Found</title>";
            echo "<h1 style='font-family: Google Sans,Roboto,Arial,sans-serif;font-size: 2.25rem; margin-top: 1.5rem; display: flex; justify-content: center'>404 Page Not Found<h1>";
            die();
        } else if(!$row_error) {
            echo "<link rel='icon' href='images_logo/background/logo_tdtu.png' type='image/icon type'>";
            echo "<title>Access Denied</title>";
            echo "<h1 style='font-family: Google Sans,Roboto,Arial,sans-serif;font-size: 2.25rem; margin-top: 1.5rem; display: flex; justify-content: center'>Access Denied<h1>";
            die();
        }
    }
function loadClassName() // for content.php
{
    if (isset($_GET)) {
        $classCode = $_GET['class'];

        $_SESSION['class'] = $classCode;
        $conn = openDB();
        $sql = "SELECT * FROM course_list WHERE class_code = '$classCode'";
        $display = mysqli_query($conn, $sql);

        if ($display->num_rows > 0) {
            while ($row = $display->fetch_assoc()) {
                $_SESSION['course_name'] =  $row['course_name'];
                $_SESSION['teacher_name'] = $row['teacher_name'];
                $_SESSION['class_code'] = $row['class_code'];
            }
        }
        closeDB($conn);
    }
}
    loadClassName();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.9.0/css/all.css">
    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="main.js"></script>
    <link rel="icon" href="images_logo/background/logo_tdtu.png" type="image/icon type">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title><?=$_SESSION['course_name']?></title>
</head>
<body>
<div class="navigation">
    <div class="navbar navbar-light bg-light border-bottom w-100">
        <div class="nav-header">
            <div class="show-sidebar btn border-0" onclick="openNav()"><i class="fal fa-bars fa-3x m-auto"></i></iv></div>
            <a class="navbar-brand mr-auto" href="./home.php"><div class="brand h4 mt-1">Ton Duc Thang <small>Classroom</small></div></a>
        </div>
        <div class="nav-items m-auto pr-3">
            <div class="nav-items-sub" id="create" style="border-bottom: 3px solid #343a40; font-weight: 500"><a href="./content.php?class=<?=$_SESSION['classcode']?>">Stream</a></div>
            <div class="nav-items-sub" id="people"><a href="./sort-all-name.php">People</a></div>
        </div>
        <div class="nav-footer h-100">
            <div class="searchbar ml-auto bg-light text-dark">
                <div class="search-field">
                    <input class="search-input text-dark" type="text" name="search-result" placeholder="Search..." >
                    <ul class="list-group search-result-list" style="position: absolute; width: 250px; display: none">
                    </ul>
                </div>
                <div class="search-icon text-dark" onclick="enableSearchBox(1)"><i class="fas fa-search"></i></div>
            </div>
        <div class="nav-welcome welcome mr-3"><span style="cursor: context-menu;">Hello,</span>
            <div style="display: inline-block; color: #3c4043; cursor: pointer;" class="nav-user mr-0 ml-0" data-toggle="popover" data-container=".navigation" data-placement="bottom" data-html="true"
                 data-content=
                 "<div class='card border-0 w-100' style='background-color: #fff!important;'>
                    <div class='card-body w-100'>
                        <h6 class='card-subtitle mb-2'>Sign In As:</h6>
                        <p class='card-text overflow-hidden text-truncate text-nowrap mb-1'><b><?=$_SESSION['username']?></b></p>
                        <p class='card-text overflow-hidden text-truncate text-nowrap'><?=$_SESSION['email']?></p>
                        <a href='./sign-out.php' class='card-link font-weight-bold'>Sign out</a>
                    </div>
                </div>"><?=$_SESSION['firstname']?></div>
        </div>
        </div>
    </div>
    <!--Sidebar Section-->
    <div class="sidebar navbar-collapse bg-light" id="navbarToggler">
        <div class="sidebar-header">
            <div class="sidebar-header-user" id="sidebar-user"><i>User Name</i></div>
            <div class="sidebar-header-home"> <!-- Sau khi đã đăng nhập thì là class = "home" -->
                <div class="home-icon"> <!-- home-icon -->
                    <i class="fas fa-home"></i>
                </div>
                <a class="nav-link" href="./home.php">Classes</a>
            </div>
        </div>
        <div class="sidebar-enrolled">
            <div class="sidebar-enrolled-title text-muted" style="cursor: context-menu;"><?php if($_SESSION['career'] == 'student'){echo "Enrolled";} else echo "Teaching";?></div>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class='nav-item nav-search' style="cursor: text;">
                    <div class='class' style='justify-items: center'>
                        <div class="search-field" style="width: 100%">
                            <input class="search-input sidebar-searchbox text-dark" type="text" name="search-result" placeholder="Search..." style="width: 100%!important;caret-color: #3c4043!important;">
                            <ul class="list-group search-result-list sidebar-result-list" style="position: absolute; width: 268px">
                            </ul>
                        </div>
                    </div>
                </li>
                <?=displayClassList(1);?>
                <li class="sidebar-create-class nav-item">
                    <div class="class">
                        <div class="class-icon">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="class-item btn nav-link" style="text-align: left; margin: 0 16px 0 16px;">Create class</div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="sidebar-footer">
            <div class="signout">
                <div class="signout-icon"> <!-- home-icon -->
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <a class="nav-link" href="sign-out.php">Sign out</a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" onclick="closeNav(); disableSearchBox(1);">
    <div class="class-content">
        <div class="class-header bg-dark text-light w-100">
            <div class="class-header-wrap p-4">
                <div class="h1 class-header-name">
                    <div class="classname-header-wrap">
                        <div class="classname-header"<?php if ($_SESSION['career'] == 'teacher') echo "contenteditable='true'"; ?> onfocus="enableEditButton()"><?=$_SESSION['course_name']?></div>
                    </div>
                    <button type="button" class="btn btn-light save-edit" style="padding-left: 1rem; padding-right: 1rem;" onclick="saveClassname()">Save</button>
                    <small class="edit-description" style="font-size: 0.8625rem; display:<?php if ($_SESSION['career'] == 'student') echo "none"; ?>" onclick="editFieldFocus()">
                        <i class="fas fa-wrench"></i>
                        <i>Click to edit</i>
                    </small>
                </div>
                <div class="class-header-teacher"><?=$_SESSION['teacher_name']?></div>
                <div class="class-header-code mt-5" style="<?php if($_SESSION['career'] == 'student') echo"display:none;"?>">Class code: <b><?=$_SESSION['class_code']?></b></div>

            </div>
        </div>
        <div class="class-body">
            <aside style="z-index: 0; flex-shrink: 0;" >
                <div class="assignment" style="background-color: white!important;">
                    <h2 class="assignment-header" style="font-size: 0.875rem;">Classwork</h2>
                    <div class="assignment-content">
                        <div class="no-work" style="text-align: center; color: rgba(0,0,0,0.549); font-size: 0.8625rem">No work due soon. Check back later!</div>
                    </div>
                </div>
            </aside>
            <div class="class-body-content">
                <div class="class-body-cell class-share">
                    <form id="share-sumbit">
                        <div class="share-section">
                            <textarea class="form-control" id="share-content" style="resize: none" data-rows="4" placeholder="Share with your class..."></textarea>
                        </div>
                    </form>
                    <div class="share-section-buttons" style="height: 0">
                        <button class="btn btn-dark post-btn" style="display: none;">Post</button>
                        <button class="btn text-dark cancel-btn" style="display: none;" onclick="hideShareButton()">Cancel</button>
                    </div>
                </div>
                <div class="class-body-cell">
                    <div class="class-body-cell-header w-100">
                        <h6 class="mb-0">Nguyen Anh Huy</h6>
                        <small>2 days ago</small>
                    </div>
                    <div class="class-body-cell-body mt-3 w-100" style=" font-size: .8275rem;">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                    <div class="class-body-cell-comment border-top pt-2 mt-4 w-100">
                        <h6 class="comment-title mb-3 text-muted">Comment</h6>
                        <div class="comment-cell">
                            <p class="mb-0 mt-2 font-weight-bold">Nguyen Anh Huy <small class="post-time">2 days ago</small></p>

                            <p class='mt-2'>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                        </div>
                    </div>
                    <div class="class-body-cell-footer w-100 border-top pt-2 mt-4">
                        <input id="comment" name= 'comment' placeholder="Add your comment">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
