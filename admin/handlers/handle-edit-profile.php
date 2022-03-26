<?php
    session_start();

    require_once("../../globals.php");
    require_once(Globals::getRoot() . "/validators.php");

    if(!isset($_SESSION["adminName"])) {
        Globals::redirectURL("admin/login.php");
    }
    else {
        if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"])) {
            Globals::redirectURL("admin/edit-profile.php");
        }
        else {
            Db::openConn();

            $id = $_SESSION["adminID"];
            $result = Db::select("admins", "*", "id = '$id'");
            if($result !== NULL) {
                $name = (isset($_POST["name"]))?Db::filterInput($_POST["name"]):"";
                $email = (isset($_POST["email"]))?Db::filterInput($_POST["email"]):"";
                $password = (isset($_POST["password"]))?Db::filterInput($_POST["password"]):"";
                $confirm = (isset($_POST["password-confirmation"]))?Db::filterInput($_POST["password-confirmation"]):"";

                // name     required - string - max-length:50
                Validator::make($name, "Name", "required|string|not-numeric|max:50");

                // email    required - email - max-length:50
                Validator::make($email, "Email", "required|email|max:50");

                // password string - max-length:25 - min-length: 6
                if(!empty($password)) {
                    Validator::make($password, "Password", "string|max:25|min:6|confirm:$confirm");
                }
                else {
                    $password = NULL;
                }

                $errors = Validator::getErrors();

                if(empty($errors)) {
                    $hashed = NULL;
                    if($password !== NULL) {
                        $hashed = password_hash($password, PASSWORD_DEFAULT);
                    }

                    $result = Db::update("admins", [
                        "name" => $name,
                        "email" => $email,
                        "password" => $hashed
                    ], "id = '$id'");

                    if($result) {
                        $_SESSION["success"] = "* Profile edited successfully";
                        $_SESSION["adminName"] = $name;
                    }
                }
                else {
                    $_SESSION["failed"] = $errors;
                }
                
                Db::closeConn();
                Globals::redirectURL("admin/edit-profile.php");
            }
            else {
                Db::closeConn();
                Globals::redirectURL("admin/login.php");
            }
        }
    }