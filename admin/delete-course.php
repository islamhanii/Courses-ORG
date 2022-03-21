<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] != "GET" || !isset($_GET["id"]))    header("location: all-courses.php");

    require_once("inc/db-connect.php");


    $id = $_GET["id"];
    $sql = "SELECT * FROM courses WHERE id = {$id}";
    $result = mysqli_query($connect, $sql);
    if($result && mysqli_num_rows($result)>0) {
        $imgName = mysqli_fetch_assoc($result)["img"];
        $sql = "DELETE FROM courses WHERE id = '$id'";
        if(mysqli_query($connect, $sql)) {
            unlink("../uploads/courses/$imgName");
            $_SESSION["success"] = "Course Deleted Successfully";
        }
    }
    else {
        $_SESSION["failed"] = "Can't delete this course";
    }

    mysqli_close($connect);
    header("location: all-courses.php");