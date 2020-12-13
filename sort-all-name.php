<?php
include_once './config.php';
include_once './course-display.php';
include_once 'send_mail.php';
    session_start();

    if(!isset($_SESSION['username'])) {
        header("Location: ./sign-in.php");
    }


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
            <div class="nav-items-sub" id="create"><a href="./content.php?class=<?=$_SESSION['class_code']?>">Stream</a></div>
            <div class="nav-items-sub" id="people" style="border-bottom: 3px solid #343a40; font-weight: 500"><a href="./sort-all-name.php">People</a></div>
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
<div class="container-fluid" onclick="closeNav(); disableSearchBox(1)">
    <div class="people-list m-auto">
        <div class="list teacher-list">
            <?php
            if(!empty($_GET['r'])){
                if ($_GET['r'] == 1) {
                    echo "<div class='alert alert-success text-center box-up' role='alert'>
                    Invitation has been sent!
                </div>";
                } else if ($_GET['r'] == 3) {
                    echo "<div class='alert alert-light text-center box-up' role='alert'>
                    Action failed. No student to remove!
                </div>";
                }
            }
            ?>
            <div class="list-title">
                <h2 class="list-title-name">Teachers</h2>
                <div class="add-people btn" data-toggle="modal" data-target="#invite-teacher-modal" style="<?php if($_SESSION['career'] == 'student') echo "display: none;"?>">
                    <i class="fal fa-user-plus"></i>
                </div>
            </div>
            <table class="list-content">
                <tbody>
                    <?php displayPeopleList('teacher')?>
                </tbody>
            </table>
        </div>
        <div class="list student-list">
            <div class="list-title">
                <h2><?php if($_SESSION['user_role'] == 'student') echo 'Classmates'; else echo 'Students'?></h2>
                <div class="add-people btn" data-toggle="modal" data-target="#invite-student-modal" style="<?php if($_SESSION['career'] == 'student') echo "display: none;"?>">
                    <i class="fal fa-user-plus"></i>
                </div>
            </div>
            <form method="post" action="delete-class.php">
            <table class="list-content">
                    <thead style="<?php if($_SESSION['user_role'] == 'student') echo 'display: none;';?>">
                    <tr>
                        <td>
                            <div class="form-check function-btn people-cell">
                                <input class="form-check-input" type="checkbox" value="" id="select_all">
                                <div class="input-group-prepend ml-3">
                                    <button class="btn btn-outline-primary" type="submit" style="z-index: 0">Remove</button>
                                </div>
                            </div>
                        </td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php displayPeopleList('student')?>
                    </tbody>
            </table>
            </form>
        </div>
    </div>
</div>


<!-- Invite Teacher Modal -->
<div class="modal fade" id="invite-teacher-modal" tabindex="-1" role="dialog" aria-labelledby="invite-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h6 class="modal-title" id="exampleModalLongTitle">Invite</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post" action="./send_mail.php" id="invite-class-teacher">
                    <table class="invite-form">
                        <tbody>
                        <tr>
                            <td>
                                <input id="request" name="invite-request" value="2" style="display: none">
                                <input id="invite-name1" name="invite-name" value="<?=$_SESSION['teacher_name']?>" style="display: none">
                                <input id="invite-role1" name="invite-role" value="teacher" style="display: none"> <!-- role in -->
                                <input id="invite-code1" name="invite-code" value="<?=$_SESSION['class_code']?>" style="display: none">
                                <input id="invite-class1" name="invite-class" value="<?=$_SESSION['course_name']?>" style="display: none">
                                <label class="mb-3" for="invite-teacher"><span class="h5">Invite teacher</span></label>
                                <input class="invite-email" id="invite-teacher" name="invite-email" placeholder="name@gmail.com" oninput="enableInviteButton()">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary invite-btn" id="invite-btn1" form="invite-class-teacher" style="padding-left: 24px; padding-right: 24px" disabled>Invite</button>
            </div>
        </div>
    </div>
</div>

<!-- Invite Student Modal -->
<div class="modal fade" id="invite-student-modal" tabindex="-1" role="dialog" aria-labelledby="invite-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h6 class="modal-title" id="exampleModalLongTitle">Invite</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="./send_mail.php" id="invite-class-student">
                    <table class="invite-form">
                        <tbody>
                        <tr>
                            <td>
                                <input id="request2" name="invite-request" value="2" style="display: none">
                                <input id="invite-name2" name="invite-name" value="<?=$_SESSION['teacher_name']?>" style="display: none">
                                <input id="invite-role2" name="invite-role" value="student" style="display: none"> <!-- role in -->
                                <input id="invite-code2" name="invite-code" value="<?=$_SESSION['class_code']?>" style="display: none">
                                <input id="invite-class2" name="invite-class" value="<?=$_SESSION['course_name']?>" style="display: none">
                                <label class="mb-3" for="invite-student"><span class="h5">Invite student</span></label>
                                <input class="invite-email" id="invite-student" name="invite-email" placeholder="name@gmail.com" oninput="enableInviteButton()">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary invite-btn" id="invite-btn2" form="invite-class-student" style="padding-left: 24px; padding-right: 24px" disabled>Invite</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
