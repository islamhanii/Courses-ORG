<?php
    if($_SERVER["REQUEST_URI"] === "/Courses-ORG/db.php")   echo "<script> window.location.href = 'index.php'; </script>";
    class Db {
        private static $connect;
        private static $hostname = "localhost";
        private static $username = "root";
        private static $password = "";
        private static $database = "courses_org";

        public static function openConn() {
            self::$connect = mysqli_connect(self::$hostname, self::$username, self::$password, self::$database);
            if(!self::$connect) {
                die("Connection Failed: " . mysqli_connect_error());
            }
        }

        public static function closeConn() {
            mysqli_close(self::$connect);
        }

        public static function filterInput($input) {
            return mysqli_real_escape_string(self::$connect, trim(htmlSpecialChars($input)));
        }

        public static function storage($image, $path)
        {
            $imageName = uniqid();
            $type = pathinfo($image["name"], PATHINFO_EXTENSION);
            $imageName = "$imageName.$type";
            move_uploaded_file($image["tmp_name"], "$path$imageName");
            return $imageName;
        }

        public static function insert($name, $data) {
            $counter = 1;
            $row = "(";
            $values = "(";

            foreach($data as $key => $value) {
                if($value !== NULL) {
                    if($counter === 1) {
                        $row .= "`$key`";
                        $values .= "'$value'";
                        $counter++;
                    }
                    else {
                        $row .= ", `$key`";
                        $values .= ", '$value'";
                    }
                }
            }
            $row .= ")";
            $values .= ")";

            $query = "INSERT INTO $name $row VALUES $values";
            if(mysqli_query(self::$connect, $query)) {
                return true;
            }
            return false;
        }

        public static function update($name, $data, $where="") {
            $counter = 1;
            $update = "";

            foreach($data as $key => $value) {
                if($value !== NULL) {
                    if($counter === 1) {
                        $update .= "`$key` = '$value'";
                        $counter++;
                    }
                    else {
                        $update .= ", `$key` = '$value'";
                    }
                }
            }

            $query = "UPDATE $name SET $update";
            if(!empty($where)) {
                $query .= " WHERE $where";
            }

            if(mysqli_query(self::$connect, $query)) {
                return true;
            }
            return false;
        }

        public static function select($name, $data, $where="", $on="", $order="", $limit="", $offset="") {
            $query = "SELECT $data FROM $name";
            if(!empty($on))  $query .= " ON $on";
            if(!empty($where))  $query .= " WHERE $where";
            if(!empty($order))  $query .= " ORDER BY $order";
            if(!empty($limit))  $query .= " LIMIT $limit";
            if(!empty($offset))  $query .= " OFFSET $offset";

            $result = mysqli_query(self::$connect, $query);
            if($result && mysqli_num_rows($result)) {
                return mysqli_fetch_all($result, MYSQLI_ASSOC);
            }
        }

        public static function delete($name, $where) {
            $query = "DELETE FROM $name WHERE $where";

            if(mysqli_query(self::$connect, $query)) {
                return true;
            }
            return false;
        }
    }
?>