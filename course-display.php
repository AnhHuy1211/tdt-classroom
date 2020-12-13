<?php
include_once './config.php';
function displayClassList($position) { /*Ham hien thi danh sach lop hoc*/
    $username = "users__".$_SESSION['username'];
    $conn = openDB();
    $sql = "SELECT * FROM $username";
    
    $class = mysqli_query($conn, $sql);

    if($_SESSION['career'] == "student"){
        $display = 'none';
    }
    else {
        $display = 'flex';
    }

    if($class->num_rows > 0) {
        if($position == 1){ /*Hien thi o sidebar*/
            while ($row = $class ->fetch_assoc()) {
                echo "<li class='nav-item'>
                    <div class='class' style='justify-items: center'>
                        <div class='class-icon'>
                            <i class='fas fa-book'></i>
                        </div>
                        <a class='class-item nav-link' href='./content.php?class=".$row['class_code']."'>".$row['course_name']."</a>
                    </div>
                </li>";
            }
        }
        else if($position == 2) { /*Hien thi o giao dien chinh*/
            while ($row = $class->fetch_assoc()) {
                echo "<li class='class-list-item list-group-item'>
            <div class='cell border border-muted mb-3'>
                <div class='cell-header bg-dark text-light border-bottom border-muted font-weight-bold'>
                    <div class='cell-option-btn class-header-item text-light position-absolute btn' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='display: $display; justify-content: center; align-items: center'>
                        <i class='fas fa-ellipsis-v'></i>
                    </div>                   
                    <div class='cell-option bg-light dropdown-menu' aria-labelledby='dropdownMenuButton'>
                        <div class='cell-option-list dropdown-item'>
                            <form method='post' action='./delete-class.php' style='display: none' id='".$row['class_code']."'>
                            <input name='delete-code' value='".$row['class_code']."'>
                            </form>                         
                                <button type='submit' class='cell-option-list-item btn delete-class' form='".$row['class_code']."'>Delete class</button>
                        </div>
                    </div>
                    <form method='get' class='cell-header-item' action='content.php'>
                        <input class='class' name='class' style='display: none;' value=" .$row['class_code'].">
                        <button class='cell-header-submit btn border-0 bg-none pl-0 pt-0'>
                            <div class='cell-header-item-h text-light'>" . $row['course_name'] . "</div>
                            <div class='cell-header-item-sh text-light pl-0'><small>" . $row['teacher_name'] . "</small></div>
                        </button>
                    </form>         
                </div>
                <div class='cell-content'>
                    <ul class='assign-list list-group'>
                        <li class='assign-list-item list-group-item'>
                            <a href='#' class='text-dark'><small>Deadline - Assignment 1</small></a>
                        </li>
                        <li class='assign-list-item list-group-item'>
                            <a href='#' class='text-dark'><small>Deadline - Assignment 2</small></a>
                        </li>
                    </ul>
                </div>
                <div class='cell-footer border-top border-muted'>
                    <a class='cell-footer-item' href='#'>Assignment</a>
                </div>
            </div>
        </li>";
            }
        }
    }

    closeDB($conn);
}


function displayPeopleList($role){
    $conn = openDB();
    $classRole = "users__". $_SESSION['username'];
    $classCode = "courses__" . $_SESSION["class_code"];
    $userRole = "";
    $sql = "SELECT * FROM $classRole WHERE class_code = '".$_SESSION['class_code']."'";
    $roleResult = mysqli_query($conn, $sql) or die($conn->error);

    if ($roleResult->num_rows > 0) {
        while ($row = $roleResult->fetch_assoc()) {
            $userRole = $row['role'];
            $_SESSION['user_role'] = $userRole;
        }
    }

    $sql = "SELECT * FROM $classCode WHERE role = '$role'";
    $load = mysqli_query($conn, $sql) or die($conn->error);

        if ($load->num_rows > 0) {
            if ($userRole == 'teacher' ){
                if($role == 'teacher'){
                    while ($row = $load->fetch_assoc()) {
                        echo "<tr>
                        <td>
                            <div class='people-cell teacher-cell'>" . $row['lastname'] . " " . $row['firstname'] . "</div>
                        </td>
                    </tr>";
                    }
                } else if ($role == 'student') {
                    while ($row = $load->fetch_assoc()) {
                        echo "<tr>
                  <td>
                        <div class='form-check student-cell people-cell'>
                            <input class='form-check-input checkbox' id='".$row['username']."' type='checkbox' name='student-name[]' value='".$row['username']."'>
                            <label class='form-check-label ml-3' for='".$row['username']."'>" .$row['lastname'] ." ".$row['firstname'] . "</label>
                        </div>
                  </td>
            </tr>";
                    }
                }
            } else if ($userRole == 'student') {
                if($role == 'teacher'){
                    while ($row = $load->fetch_assoc()) {
                        echo "<tr>
                        <td>
                            <div class='people-cell teacher-cell'>" . $row['lastname'] . " " . $row['firstname'] . "</div>
                        </td>
                    </tr>";
                    }
                } else if ($role == 'student') {
                    while ($row = $load->fetch_assoc()) {
                        echo "<tr>
                  <td>
                        <div class='student-cell people-cell'>".$row['lastname'] . " " . $row['firstname']."</div>
                  </td>
            </tr>";
                    }
                }
            }

    }
    closeDB($conn);
}
