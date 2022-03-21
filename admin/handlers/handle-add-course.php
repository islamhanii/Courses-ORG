<?php
    session_start();
    
    if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"]))    header("location: ../all-courses.php");

    require_once("../inc/db-connect.php");

    $name = (isset($_POST["name"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["name"]))):"";
    $desc = (isset($_POST["desc"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["desc"]))):"";
    $img = (isset($_FILES["img"]))?$_FILES["img"]:"";
    $cat_id = (isset($_POST["cat_id"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["cat_id"]))):"";;
    $errors = [];

    // name     required - string - max-length:50
    if(empty($name)) {
        array_push($errors, "* Name is required.");
    }
    else if(!is_string($name) || is_numeric($name)) {
        array_push($errors, "* Name should contains characters.");
    }
    else if(strlen($name)>50) {
        array_push($errors, "* Name should be less than 50 characters.");
    }

    // desc    required - desc - max-length:65000
    if(empty($desc)) {
        array_push($errors, "* Description is required.");
    }
    else if(!is_string($desc)) {
        array_push($errors, "* Enter valid description.");
    }
    else if(strlen($desc)>65000) {
        array_push($errors, "* Description should be less than 65000 characters.");
    }

    // img     required - max-size: 2MB - type: (jpg - jpeg - png)
    if(!empty($img)) {
        $validTypes = ["jpg", "jpeg", "png"];
        $type = pathinfo($img["name"], PATHINFO_EXTENSION);
        $size = $img["size"]/(1024*1024);
    }

    if(empty($img) || $img["error"]!==0) array_push($errors, "* Error while uploading the image (image required)");
    else if(!in_array(strtolower($type), $validTypes)) array_push($errors, "* Please enter image of type [png, jpg, or jpeg]");
    else if($size>2) array_push($errors, "* Please enter image with max size: 2Mb");

    // cat_id    required - nemuric - isfound
    if(empty($cat_id)) {
        array_push($errors, "* Category is required.");
    }
    else if(!is_numeric($cat_id)) {
        array_push($errors, "* Category should be a number.");
    }

    $sql = "SELECT id FROM cats WHERE id = $cat_id";
    $result = mysqli_query($connect, $sql);
    if($result && mysqli_num_rows($result)===0) {
        array_push($errors, "* Enter a valid category.");
    }


    if(empty($errors)) {
        $imageName = uniqid();
        $imageName = "$imageName.$type";
        move_uploaded_file($img["tmp_name"], "../../uploads/courses/$imageName");

        $sql = "INSERT INTO courses(`name`, `desc`, img, cat_id) VALUES('$name', '$desc', '$imageName', '$cat_id');";

        if(mysqli_query($connect, $sql)) {
            $_SESSION["success"] = "* Course added successfully";
            mysqli_close($connect);
            header("location: ../all-courses.php");
        }
    }

    mysqli_close($connect);
    $_SESSION["failed"] = $errors;
    $_SESSION["post"] = $_POST;
    header("location: ../add-course.php");



    

