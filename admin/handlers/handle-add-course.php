<?php
    session_start();
    
    include_once("../../globals.php");
    include_once(Globals::getRoot() . "/validators.php");
    if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"]))    Globals::redirectURL("admin/all-courses.php");

    require_once("../inc/db-connect.php");

    $name = (isset($_POST["name"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["name"]))):"";
    $desc = (isset($_POST["desc"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["desc"]))):"";
    $img = (isset($_FILES["img"]))?$_FILES["img"]:"";
    $cat_id = (isset($_POST["cat_id"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["cat_id"]))):"";

    // name     required - string - max-length:50
    Validator::make($name, "Name", "required|string|not-numeric|max:50");

    // desc    required - string - max-length:65000
    Validator::make($desc, "Description", "required|string|not-numeric|max:65000");

    // img     required - max-size: 2MB - type: (jpg - jpeg - png)
    Validator::make($img, "Image", "required|image|mimes:jpg,jpeg,png|size:2");

    // cat_id    required - nemuric - isfound
    Validator::make($cat_id, "Category", "required|numeric");

    $errors = Validator::getErrors();

    $sql = "SELECT id FROM cats WHERE id = $cat_id";
    $result = mysqli_query($connect, $sql);
    if($result && mysqli_num_rows($result)===0) {
        array_push($errors, "* Enter a valid category.");
    }


    if(empty($errors)) {
        $imageName = uniqid();
        $type = pathinfo($img["name"], PATHINFO_EXTENSION);
        $imageName = "$imageName.$type";
        move_uploaded_file($img["tmp_name"], Globals::getRoot()."/uploads/courses/$imageName");

        $sql = "INSERT INTO courses(`name`, `desc`, img, cat_id) VALUES('$name', '$desc', '$imageName', '$cat_id');";

        if(mysqli_query($connect, $sql)) {
            $_SESSION["success"] = "* Course added successfully";
            mysqli_close($connect);
            Globals::redirectURL("admin/all-courses.php");
        }
    }

    mysqli_close($connect);
    $_SESSION["failed"] = $errors;
    $_SESSION["post"] = $_POST;
    Globals::redirectURL("admin/add-course.php");



    

