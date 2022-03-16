<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"]))    header("location: ../add-category.php");

    require_once("../inc/db-connect.php");

    $name = (isset($_POST["name"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["name"]))):"";
    
    $error = "";
    
    // Name    required - string - max-length:50
    if(empty($name)) {
        $error = "* Name is required.";
    }
    else if(!is_string($name) || is_numeric($name)) {
        $error = "* Name should contains characters.";
    }
    else if(strlen($name)>50) {
        $error = "* Name should be less than 50 characters.";
    }

    if(empty($error)) {
        $sql = "INSERT INTO cats (`name`) VALUES ('$name');";
        if(mysqli_query($connect, $sql)) {
            $_SESSION["success"] = "* Category added successfully";
            mysqli_close($connect);
            header("location: ../all-categories.php");
        }
    }
    else {
        $_SESSION["failed"] = $error;
        $_SESSION["post_name"] = $name;
    }

    mysqli_close($connect);
    header("location: ../add-category.php");