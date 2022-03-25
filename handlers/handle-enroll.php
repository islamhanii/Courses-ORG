<?php
    session_start();
    
    include_once("../globals.php");
    include_once(Globals::getRoot() . "/validators.php");

    if($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST["submit"]))    Globals::redirectURL();
    else {
        Db::openConn();

        $name = (isset($_POST["name"]))?Db::filterInput($_POST["name"]):"";
        $email = (isset($_POST["email"]))?Db::filterInput($_POST["email"]):"";
        $phone = (isset($_POST["phone"]))?Db::filterInput($_POST["phone"]):"";
        $spec = (isset($_POST["spec"]))?Db::filterInput($_POST["spec"]):"";
        $course_id = (isset($_POST["course_id"]))?Db::filterInput($_POST["course_id"]):"";

        // name     required - string - max-length:50
        Validator::make($name, "Name", "required|string|not-numeric|max:50");

        // email    required - email - max-length:50
        Validator::make($email, "Email", "required|email|max:50");

        // phone    required - string - max-length:25
        Validator::make($phone, "Phone", "required|string|max:25");

        // spec     string - max-length: 50
        if(!empty($spec)) {
            Validator::make($spec, "Speciality", "string|not-numeric|max:25");
        }
        else {
            $spec = NULL;
        }

        // course_id    required - nemuric - isfound
        Validator::make($course_id, "Course", "required|numeric|is-found:courses");
        
        $errors = Validator::getErrors();

        if(empty($errors)) {
            $result = Db::select("reservations", "id", "email = '$email' AND course_id = '$course_id'");
            if($result !== NULL) {
                array_push($errors, "* You can't enroll a course twice.");
                $_SESSION["failed"] = $errors;
                $_SESSION["post"] = $_POST;
            }
            else {
                $result = Db::insert("reservations", [
                    "name" => $name,
                    "email" => $email,
                    "phone" => $phone,
                    "spec" => $spec,
                    "course_id" => $course_id
                ]);

                if($result) {
                    $_SESSION["success"] = "* You enrolled to the course successfully";
                }
            }
        }
        else {
            $_SESSION["failed"] = $errors;
            $_SESSION["post"] = $_POST;
        }
        Db::openConn();
        Globals::redirectURL("enroll.php");
    }



    

