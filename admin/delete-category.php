<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] != "GET" || !isset($_GET["id"]))    header("location: all-categories.php");

    require_once("inc/db-connect.php");


    $id = $_GET["id"];
    $sql = "SELECT * FROM cats WHERE id = {$id}";
    $result = mysqli_query($connect, $sql);
    if($result && mysqli_num_rows($result)>0) {
        $sql = "DELETE FROM cats WHERE id = '$id'";
        if(mysqli_query($connect, $sql)) {
            $_SESSION["success"] = "Category Deleted Successfully";
        }
    }
    else {
        $_SESSION["failed"] = "Can't delete this category";
    }

    mysqli_close($connect);
    header("location: all-categories.php");