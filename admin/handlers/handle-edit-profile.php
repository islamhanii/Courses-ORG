<?php
    session_start();

    include_once("../../globals.php");
    include_once(Globals::getRoot() . "/validators.php");
    if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"]))    Globals::redirectURL("admin/edit-profile.php");

    require_once("../inc/db-connect.php");

    $id = $_SESSION["adminID"];
    $sql = "SELECT * FROM admins WHERE id = $id";
    $result = mysqli_query($connect, $sql);
    if($result && mysqli_num_rows($result)>0) {
        
        $name = (isset($_POST["name"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["name"]))):"";
        $email = (isset($_POST["email"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["email"]))):"";
        $password = (isset($_POST["password"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["password"]))):"";
        $confirm = (isset($_POST["password-confirmation"]))?mysqli_real_escape_string($connect, trim(htmlSpecialChars($_POST["password-confirmation"]))):"";

        $validatorObj = new Validator();
        // name     required - string - max-length:50
        $validatorObj->make($name, "Name", "required|string|not-numeric|max:50");

        // email    required - email - max-length:50
        $validatorObj->make($email, "Email", "required|email|max:50");

        // password string - max-length:25 - min-length: 6
        if(!empty($password)) {
            $validatorObj->make($password, "Password", "string|max:25|min:6|confirm:$confirm");
        }
        else {
            $password = NULL;
        }

        $errors = $validatorObj->getErrors();

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
        Globals::redirectURL("admin/edit-profile.php");
    }

    mysqli_close($connect);
    Globals::redirectURL("admin/login.php");

    

