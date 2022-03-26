<?php
    session_start();
    require_once("../globals.php");
    if(!isset($_SESSION["adminName"])) {
        Globals::redirectURL("admin/login.php");
    }
    else {
        if($_SERVER["REQUEST_METHOD"] != "GET" || !isset($_GET["id"]))    Globals::redirectURL("admin/all-categories.php");

        else {
            Db::openConn();

            $id = $_GET["id"];
            $sql = "SELECT * FROM cats WHERE id = {$id}";
            $result = Db::select("cats", "*", "id = '$id'");
            if($result !== NULL) {
                $result = Db::delete("cats", "id = '$id'");
                if($result) {
                    $_SESSION["success"] = "Category Deleted Successfully";
                }
            }
            else {
                $_SESSION["failed"] = "Can't delete this category";
            }

            Db::closeConn();
            Globals::redirectURL("admin/all-categories.php");
        }
    }