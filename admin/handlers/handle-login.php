<?php
    session_start();

    require_once("../../globals.php");
    require_once(Globals::getRoot() . "/validators.php");
    if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"])) {
        Globals::redirectURL("admin/login.php");
    }
    else {
        Db::openConn();

        $email = (isset($_POST["email"]))?Db::filterInput($_POST["email"]):"";
        $password = (isset($_POST["password"]))?Db::filterInput($_POST["password"]):"";
        $_SESSION["post_email"] = $email;
        
        // email    required - email - max-length:50
        Validator::make($email, "Email", "required|email|max:50");

        // password    required - string - length: [5 < 25]
        Validator::make($password, "Password", "required|string|max:25|min:6");

        $errors = Validator::getErrors();
        
        if(empty($errors)) {
            $result = Db::select("admins", "*", "email = '$email'");
            
            if($result !== NULL) {
                $admin = $result[0];
                if(password_verify($password, $admin["password"])) {
                    $_SESSION["adminID"] = $admin["id"];
                    $_SESSION["adminName"] = $admin["name"];
                    unset($_SESSION["post_email"]);
                }
                else {
                    $_SESSION["login_error"] = "* Wrong email or password";
                }
            }
        }
        else {
            $_SESSION["failed"] = $errors;
        }

        Db::closeConn();
        if(isset($_SESSION["adminName"])) {
            Globals::redirectURL("admin/index.php");
        }
        else {
            Globals::redirectURL("admin/login.php");
        }
    }