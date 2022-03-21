<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"]))    header("location: ../edit-profile.php");

    require_once("../inc/db-connect.php");

    $id = $_SESSION["adminID"];
    $sql = "SELECT * FROM admins WHERE id = $id";
    $result = mysqli_query($connect, $sql);
    if($result && mysqli_num_rows($result)>0) {
        
        $name = (isset($_POST["name"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["name"]))):"";
        $email = (isset($_POST["email"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["email"]))):"";
        $password = (isset($_POST["password"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["password"]))):"";
        $confirm = (isset($_POST["password-confirmation"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["password-confirmation"]))):"";
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

        // password string - max-length:25 - min-length: 6
        if(!empty($password)) {
            if(!is_string($password)) {
                array_push($errors, "* password should be string.");
            }
            else if(strlen($password)>25 || strlen($password)<6) {
                array_push($errors, "* Password should be between than 50 characters.");
            }
            else if($password !== $confirm) {
                array_push($errors, "* Wrong password confirmation");
            }
        }
        else {
            $password = NULL;
        }


        if(empty($errors)) {
            if($password === NULL) {
                $sql = "UPDATE admins SET `name` = '$name', `email` = '$email' WHERE id = '$id';";
            }
            else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);

                $sql = "UPDATE admins SET `name` = '$name', `email` = '$email', `password` = '$hashed' WHERE id = '$id';";
            }

            if(mysqli_query($connect, $sql)) {
                $_SESSION["success"] = "* Profile edited successfully";
                $_SESSION["adminName"] = $name;
            }
        }
        else {
            $_SESSION["failed"] = $errors;
        }
        
        mysqli_close($connect);
        header("location: ../edit-profile.php");
    }

    mysqli_close($connect);
    header("location: ../login.php");

    

