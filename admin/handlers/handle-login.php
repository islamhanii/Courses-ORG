<?php
    session_start();

    include_once("../../globals.php");
    include_once(Globals::getRoot() . "/validators.php");
    if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"]))    Globals::redirectURL("admin/login.php");

    require_once("../inc/db-connect.php");

    $email = (isset($_POST["email"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["email"]))):"";
    $password = (isset($_POST["password"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["password"]))):"";
    $_SESSION["post_email"] = $email;
    
    // email    required - email - max-length:50
    Validator::make($email, "Email", "required|email|max:50");

    // password    required - string - length: [5 < 25]
    Validator::make($password, "Password", "required|string|max:25|min:6");

    $errors = Validator::getErrors();
    
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
    if(isset($_SESSION["adminName"]))   Globals::redirectURL("admin/index.php");
    else Globals::redirectURL("admin/login.php");