<?php
function openDB() {
    $conn = mysqli_connect("remotemysql.com","pOqRYb14Gu","lyJJlsnCyX","pOqRYb14Gu");
    return $conn;
}

function closeDB($conn) {
    $conn->close();
}
?>