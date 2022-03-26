<?php
    session_start();

    require_once("../../globals.php");
    require_once(Globals::getRoot() . "/validators.php");

    if(!isset($_SESSION["adminName"])) {
        Globals::redirectURL("admin/login.php");
    }
    else {
        if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"]) || !isset($_GET["id"])) {
            Globals::redirectURL("admin/all-categories.php");
        }
        else {
            Db::openConn();

            $id = $_GET["id"];
            $result = Db::select("cats", "*", "id = '$id'");
            if($result !== NULL) {
                $name = (isset($_POST["name"]))?Db::filterInput($_POST["name"]):"";
            
                // name     required - string - max-length:50
                Validator::make($name, "Name", "required|string|not-numeric|max:50");

                $errors = Validator::getErrors();

                if(empty($errors)) {
                    $result = Db::update("cats", [
                        "name" => $name
                    ], "id = '$id'");
                    
                    if($result) {
                        $_SESSION["success"] = "Category Edited successfully";
                    }
                }
                else {
                    $_SESSION["failed"] = $errors[0];
                    Db::closeConn();
                    Globals::redirectURL("admin/edit-category.php?id=$id");
                }
            }

            Db::closeConn();
            Globals::redirectURL("admin/all-categories.php");
        }
    }