<?php
    session_start();
    
    if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"]))    header("location: ../");
    
    $hostname = "localhost";
    $database = "courses_org";
    $username = "root";
    $password = "";

    $connect = mysqli_connect($hostname, $username, $password, $database);
    if(!$connect) {
        die("Connection Failed: " . mysqli_connect_error());
    }

    $name = (isset($_POST["name"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["name"]))):"";
    $email = (isset($_POST["email"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["email"]))):"";
    $phone = (isset($_POST["phone"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["phone"]))):"";
    $spec = (isset($_POST["spec"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["spec"]))):"";
    $course_id = (isset($_POST["course_id"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["course_id"]))):"";;
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

    // email    required - email - max-length:50
    if(empty($email)) {
        array_push($errors, "* Email is required.");
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "* Enter valid email.");
    }
    else if(strlen($email)>50) {
        array_push($errors, "* Email should be less than 50 characters.");
    }

    // phone    required - string - max-length:25
    if(empty($phone)) {
        array_push($errors, "* Phone is required.");
    }
    else if(!is_string($phone)) {
        array_push($errors, "* Enter correct phone number.");
    }
    else if(strlen($phone)>25) {
        array_push($errors, "* Phone should be less than 25 characters.");
    }

    // spec     string - max-length: 50
    if(!empty($spec)) {
        if(!is_string($spec)) {
            array_push($errors, "* Speciality should contains characters only.");
        }
        else if(strlen($spec)>25) {
            array_push($errors, "* Speciality should be less than 50 characters.");
        }
    }
    else $spec = NULL;

    // course_id    required - nemuric - isfound
    if(empty($course_id)) {
        array_push($errors, "* Course is required.");
    }
    else if(!is_numeric($course_id)) {
        array_push($errors, "* Course should be a number.");
    }

    $sql = "SELECT id FROM courses WHERE id = $course_id";
    $result = mysqli_query($connect, $sql);
    if($result && mysqli_num_rows($result)===0) {
        array_push($errors, "* Enter a valid course.");
    }


    if(empty($errors)) {
        $sql = "SELECT id FROM reservations WHERE email = '$email' AND course_id = '$course_id';";
        $result = mysqli_query($connect, $sql);
        if($result && mysqli_num_rows($result)>0) {
            array_push($errors, "* You can't enroll a course twice.");
            $_SESSION["failed"] = $errors;
            $_SESSION["post"] = $_POST;
        }
        else {
            if($spec === NULL)  $sql = "INSERT INTO reservations(`name`, email, phone, course_id) VALUES('$name', '$email', '$phone', '$course_id');";
            else $sql = "INSERT INTO reservations(`name`, email, phone, spec, course_id) VALUES('$name', '$email', '$phone', '$spec', '$course_id');";

            if(mysqli_query($connect, $sql)) {
                $_SESSION["success"] = "* You enrolled to the course successfully";
            }
        }
        mysqli_close($connect);
    }
    else {
        $_SESSION["failed"] = $errors;
        $_SESSION["post"] = $_POST;
    }
    header("location: ../enroll.php");



    

