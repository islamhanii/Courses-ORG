<?php
    session_start();

    require_once("../../globals.php");
    require_once(Globals::getRoot() . "/validators.php");

    if(!isset($_SESSION["adminName"])) {
        Globals::redirectURL("admin/login.php");
    }
    else {
        if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"])) {
            Globals::redirectURL("admin/all-categories.php");
        }
        else {
            Db::openConn();

            $name = (isset($_POST["name"]))?Db::filterInput($_POST["name"]):"";
            
            // name     required - string - max-length:50
            Validator::make($name, "Name", "required|string|not-numeric|max:50");

            $errors = Validator::getErrors();

            if(empty($errors)) {
                $result = Db::insert("cats", [
                    "name" => $name
                ]);
                if($result) {
                    $_SESSION["success"] = "* Category added successfully";
                    Db::closeConn();
                    Globals::redirectURL("admin/all-categories.php");
                }
            }
            else {
                $_SESSION["failed"] = $errors[0];
                $_SESSION["post_name"] = $name;
            }

            Db::closeConn();
            Globals::redirectURL("admin/add-category.php");
        }
    }