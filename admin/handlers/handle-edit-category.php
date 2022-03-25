<?php
    session_start();

    include_once("../../globals.php");
    include_once(Globals::getRoot() . "/validators.php");
    if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"]) || !isset($_GET["id"]))    Globals::redirectURL("admin/all-categories.php");

    require_once("../inc/db-connect.php");

    $id = $_GET["id"];
    $sql = "SELECT * FROM cats WHERE id = {$id}";
    $result = mysqli_query($connect, $sql);
    if($result && mysqli_num_rows($result)>0) {
        $name = (isset($_POST["name"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["name"]))):"";
    
        // name     required - string - max-length:50
        Validator::make($name, "Name", "required|string|not-numeric|max:50");

        $errors = Validator::getErrors();

        if(empty($errors)) {
            $sql = "UPDATE cats SET `name` = '$name' WHERE id = '$id'";
            if(mysqli_query($connect, $sql)) {
                $_SESSION["success"] = "Category Edited successfully";
            }
        }
        else {
            $_SESSION["failed"] = $errors[0];
            mysqli_close($connect);
            Globals::redirectURL("admin/edit-category.php?id=$id");
        }
    }

    mysqli_close($connect);
    Globals::redirectURL("admin/all-categories.php");