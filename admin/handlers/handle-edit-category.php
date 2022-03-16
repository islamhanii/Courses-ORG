<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"]) || !isset($_GET["id"]))    header("location: ../all-categories.php");

    require_once("../inc/db-connect.php");

    $id = $_GET["id"];
    $sql = "SELECT * FROM cats WHERE id = {$id}";
    $result = mysqli_query($connect, $sql);
    if($result && mysqli_num_rows($result)>0) {
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
            $sql = "UPDATE cats SET `name` = '$name' WHERE id = '$id'";
            if(mysqli_query($connect, $sql)) {
                $_SESSION["success"] = "Category Edited successfully";
            }
        }
        else {
            $_SESSION["failed"] = $error;
            mysqli_close($connect);
            header("location: ../edit-category.php?id=$id");
        }
    }

    mysqli_close($connect);
    header("location: ../all-categories.php");