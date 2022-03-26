<?php
    session_start();
    require_once("../globals.php");
    if(!isset($_SESSION["adminName"])) {
        Globals::redirectURL("admin/login.php");
    }
    else {
        if($_SERVER["REQUEST_METHOD"] != "GET" || !isset($_GET["id"]))    Globals::redirectURL("admin/all-courses.php");

        else {
            Db::openConn();

            $id = $_GET["id"];
            $result = Db::select("courses", "*", "id = '$id'");
            if($result !== NULL) {
                $imgName = $result[0]["img"];
                $result = Db::delete("courses", "id = '$id'");
                if($result) {
                    unlink(Globals::getRoot() . "/uploads/courses/$imgName");
                    $_SESSION["success"] = "Course Deleted Successfully";
                }
            }
            else {
                $_SESSION["failed"] = "Can't delete this course";
            }

            Db::closeConn();
            Globals::redirectURL("admin/all-courses.php");
        }
    }