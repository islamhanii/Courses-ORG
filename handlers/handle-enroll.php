<?php
    session_start();
    
    include_once("../globals.php");
    include_once(Globals::getRoot() . "/validators.php");

    if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"]))    Globals::redirectURL();
    else {
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
        $course_id = (isset($_POST["course_id"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["course_id"]))):"";

        $validatorObj = new Validator();
        // name     required - string - max-length:50
        $validatorObj->make($name, "Name", "required|string|not-numeric|max:50");

        // email    required - email - max-length:50
        $validatorObj->make($email, "Email", "required|email|max:50");

        // phone    required - string - max-length:25
        $validatorObj->make($phone, "Phone", "required|string|max:25");

        // spec     string - max-length: 50
        if(!empty($spec)) {
            $validatorObj->make($spec, "Speciality", "string|not-numeric|max:25");
        }
        else {
            $spec = NULL;
        }

        // course_id    required - nemuric - isfound
        $validatorObj->make($course_id, "Course", "required|numeric");

        
        $errors = $validatorObj->getErrors();

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
        }
        else {
            $_SESSION["failed"] = $errors;
            $_SESSION["post"] = $_POST;
        }
        mysqli_close($connect);
        Globals::redirectURL("enroll.php");
    }



    

