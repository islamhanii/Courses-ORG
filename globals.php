<?php
    if($_SERVER["REQUEST_URI"] === "/Courses-ORG/globals.php")   echo "<script> window.location.href = 'index.php'; </script>";
    require_once("db.php");
    
    class Globals {
        public static $root = __DIR__;
        public static $url = "http://localhost/Courses-ORG/";

        // getters
        public static function getRoot()
        { return self::$root; }

        public static function getURL()
        { return self::$url; }

        // change url
        public static function redirectURL($var = "")
        {
            $var = self::$url . $var;
            echo "<script> window.location.href = '$var'; </script>";
        }
    }
?>