<?php
    session_start();
    
    require_once("../../globals.php");
    require_once(Globals::getRoot() . "/validators.php");
    
    if(!isset($_SESSION["adminName"])) {
        Globals::redirectURL("admin/login.php");
    }
    else {
        if($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["submit"])) {
            Globals::redirectURL("admin/all-courses.php");
        }
        else {
            Db::openConn();

            $name = (isset($_POST["name"]))?Db::filterInput($_POST["name"]):"";
            $desc = (isset($_POST["desc"]))?Db::filterInput($_POST["desc"]):"";
            $img = (isset($_FILES["img"]))?$_FILES["img"]:"";
            $cat_id = (isset($_POST["cat_id"]))?Db::filterInput($_POST["cat_id"]):"";

            // name     required - string - max-length:50
            Validator::make($name, "Name", "required|string|not-numeric|max:50");

            // desc    required - string - max-length:65000
            Validator::make($desc, "Description", "required|string|not-numeric|max:65000");

            // img     required - max-size: 2MB - type: (jpg - jpeg - png)
            Validator::make($img, "Image", "required|image|mimes:jpg,jpeg,png|size:2");

            // cat_id    required - nemuric - isfound
            Validator::make($cat_id, "Category", "required|numeric|is-found:cats");

            $errors = Validator::getErrors();

            if(empty($errors)) {
                $imageName = Db::storage($img, Globals::getRoot()."/uploads/courses/");

                $result = Db::insert("courses", [
                    "name" => $name,
                    "desc" => $desc,
                    "img" => $imageName,
                    "cat_id" => $cat_id
                ]);

                if($result) {
                    $_SESSION["success"] = "* Course added successfully";
                    Db::closeConn();
                    Globals::redirectURL("admin/all-courses.php");
                }
            }

            else {
                Db::closeConn();
                $_SESSION["failed"] = $errors;
                $_SESSION["post"] = $_POST;
                Globals::redirectURL("admin/add-course.php");
            }
        }
    }



    

