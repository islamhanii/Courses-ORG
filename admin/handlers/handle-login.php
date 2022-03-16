<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"]))    header("location: ../login.php");

    require_once("../inc/db-connect.php");

    $email = (isset($_POST["email"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["email"]))):"";
    $password = (isset($_POST["password"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["password"]))):"";
    $_SESSION["post_email"] = $email;
    
    $errors = [];
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

    // password    required - string - length: [5 < 25]
    if(empty($password)) {
        array_push($errors, "* Password is required.");
    }
    else if(!is_string($password)) {
        array_push($errors, "* Password should contains characters.");
    }
    else if(strlen($password)<5 || strlen($password)>25) {
        array_push($errors, "* Password should be between 5 and 25 characters.");
    }

    if(empty($errors)) {
        $_SESSION["login_error"] = "* Wrong email or password";

        $sql = "SELECT * FROM admins WHERE email = '$email';";
        $result = mysqli_query($connect, $sql);
        
        if($result && mysqli_num_rows($result)>0) {
            $admin = mysqli_fetch_assoc($result);

            if(password_verify($password, $admin["password"])) {
                $_SESSION["adminID"] = $admin["id"];
                $_SESSION["adminName"] = $admin["name"];
                unset($_SESSION["login_error"]);
                unset($_SESSION["post_email"]);
            }
        }
    }
    else {
        $_SESSION["failed"] = $errors;
    }

    mysqli_close($connect);
    if(isset($_SESSION["adminName"]))   header("location: ../index.php");
    else header("location: ../login.php");