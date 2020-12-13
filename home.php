<?php
session_start();
include_once './course-display.php';
if(!isset($_SESSION['username'])) {
    header('Location: ./sign-in.php');
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

    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.9.0/css/all.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="main.js"></script>
    <link rel="icon" href="./images_logo/background/logo_tdtu.png" type="image/icon type">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Home</title>
    <script> $(document).ready(function(){ $('.toast').toast('show'); }); </script>
</head>
<body>
<div class="navigation">
    <div class="navbar navbar-light bg-light border-bottom w-100 normal-navbar">
        <div class="nav-header">
            <div class="show-sidebar btn border-0" onclick="openNav()"><i class="fal fa-bars fa-3x m-auto"></i></iv></div>
            <a class="navbar-brand mr-auto" href="home.php"><div class="brand h4 mt-1">Ton Duc Thang <small>Classroom</small></div></a>
        </div>
        <div class="nav-footer h-100">
            <div class="searchbar ml-auto bg-light text-dark">
                <div class="search-field">
                    <input class="search-input text-dark" type="text" name="search-result" placeholder="Search...">
                    <ul class="list-group search-result-list" style="position: absolute; width: 250px; display: none">
                    </ul>
                </div>
                <div class="search-icon text-dark" onclick="enableSearchBox(1)"><i class="fas fa-search"></i></div>
            </div>
        <div class="btn fas fa-plus mr-3 " id="plus-icon" data-toggle="modal" data-target="#<?php if($_SESSION['career'] == 'student'){echo "join";} else echo "create";?>-class-modal"></div>
        <div class="nav-welcome welcome mr-3 pb-1"><span style="cursor: context-menu;">Hello,</span>
            <div style="display: inline-block; color: #3c4043; cursor: pointer;" class="nav-user mr-0 ml-0" data-toggle="popover" data-container=".navigation" data-placement="bottom" data-html="true"
               data-content=
               "<div class='card border-0 w-100' style='background-color: #fff!important;'>
                    <div class='card-body w-100'>
                        <h5 class='card-subtitle mb-3'>Sign In As:</h5>
                        <p class='card-text overflow-hidden text-truncate text-nowrap mb-1'><b><?=$_SESSION['username']?></b></p>
                        <p class='card-text overflow-hidden text-truncate text-nowrap'><?= $_SESSION['email']?></p>
                        <a href='./sign-out.php' class='card-link font-weight-bold'>Sign out</a>
                    </div>
                </div>"><?=$_SESSION['firstname']?></div>
        </div>
        </div>
    </div>
    <div class="sidebar navbar-collapse bg-light" id="navbarToggler">
        <div class="sidebar-header">
            <div class="sidebar-header-user" id="sidebar-user"><i>User Name</i></div>
            <div class="sidebar-header-home"> <!-- Sau khi đã đăng nhập thì là class = "home" -->
                <div class="home-icon fas fa-home"> <!-- home-icon -->
                </div>
                <a class="nav-link" href="home.php">Home</a>
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
                <!-- side bar class list -->
                <?php displayClassList(1);?>
                <li class="sidebar-create-class nav-item" data-toggle="modal" data-target="#<?php if($_SESSION['career'] == 'student'){echo "join";} else echo "create";?>-class-modal">
                    <div class="class">
                        <div class="class-icon fas fa-plus">
                        </div>
                        <div class="class-item btn nav-link" style="text-align: left; margin: 0 16px 0 16px;"><?php if($_SESSION['career'] == 'student'){echo "Join class";} else echo "Create class";?></div>
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
    <div aria-live="polite" aria-atomic="true" style="pointer-events: none; position: fixed; min-width: 100%; min-height: 200px; z-index: 100">
        <?php
        if(!empty($_GET['r'])) {
            if($_GET['r'] == 2) {
                echo "<div class='toast border box-up' style='position: absolute;min-width: 15.8675rem; top: 0; right: 30px; border-radius: .5rem; ' data-autohide='false'>
            <div class='toast-body' style='background-color: #fff; border: 1px solid #fff;border-radius: .5rem; display: flex; flex-direction: row; align-items: center'>
                <div class='rounded mr-2 text-success my-auto' style='font-size: .5rem; display: flex; flex-direction: column; align-items: center'>
                    <i class='fas fa-check fa-2x'></i>
                </div>
                <div class='ml-2 my-auto text-dark'>
                    <div class='h6 mb-0'>Successfully</div>
                    <div>Request has been sent to your teacher</div>
                </div>
                <button type='button' class='ml-4 mb-1 close' data-dismiss='toast' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
        </div>";
            }
        }
        ?>
    </div>
    <ul class="class-list list-group">
        <!-- add class here -->
        <?php displayClassList(2);?>
    </ul>
</div>
<!-- Modal for Join Class-->
<div class="modal fade" id="join-class-modal" tabindex="-1" role="dialog" aria-labelledby="join-class-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h6 class="modal-title" id="exampleModalLongTitle">Join class</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="send_mail.php" id="join-class">
                    <table class="create-class-form">
                        <tbody>
                        <tr>
                            <td>
                                <label for="class-code"><b>Enter class code</b></label>
                                <small class ="class-code-description mb-4">Ask your teacher for the class code, then enter it here.</small>
                                <input id="class-code" name="class-code" placeholder="Code" oninput="enableModalButton()">
                                <input name="student-firstname" value="<?=$_SESSION['firstname']?>" style="display: none">
                                <input name="student-lastname" value="<?=$_SESSION['lastname']?>" style="display: none">
                                <input name="student-email" value="<?=$_SESSION['email']?>" style="display: none">
                                <input name="student-username" value="<?=$_SESSION['username']?>" style="display: none">
                                <input name="student-role" value="student" style="display: none">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer border-0" >
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary add-class-btn" id="join-btn" form="join-class" style="padding-left: 24px; padding-right: 24px" disabled>Join</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Create Class -->
<div class="modal fade" id="create-class-modal" tabindex="-1" role="dialog" aria-labelledby="create-class-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h6 class="modal-title" id="exampleModalLongTitle">Create class</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="course-loader.php" id="create-class">
                    <table class="create-class-form">
                        <tbody>
                        <tr>
                            <td>
                                <label class="mb-3" for="class-name"><span class="h4">Class name</span></label>
                                <input id="class-name" name="class-name" placeholder="Mathematics, Physic, Chemistry, etc" oninput="enableModalButton()">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary add-class-btn" id="create-btn" form="create-class" style="padding-left: 24px; padding-right: 24px" disabled>Create</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>