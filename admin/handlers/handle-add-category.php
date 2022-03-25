<?php
    session_start();

    include_once("../../globals.php");
    include_once(Globals::getRoot() . "/validators.php");
    if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"]))    Globals::redirectURL("admin/add-category.php");

    require_once("../inc/db-connect.php");

    $name = (isset($_POST["name"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["name"]))):"";
    
    // name     required - string - max-length:50
    Validator::make($name, "Name", "required|string|not-numeric|max:50");

    $errors = Validator::getErrors();

    if(empty($errors)) {
        $sql = "INSERT INTO cats (`name`) VALUES ('$name');";
        if(mysqli_query($connect, $sql)) {
            $_SESSION["success"] = "* Category added successfully";
            mysqli_close($connect);
            Globals::redirectURL("admin/all-categories.php");
        }
    }
    else {
        $_SESSION["failed"] = $errors[0];
        $_SESSION["post_name"] = $name;
    }

    mysqli_close($connect);
    Globals::redirectURL("admin/add-category.php");