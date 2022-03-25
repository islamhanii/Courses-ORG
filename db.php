<?php
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

        public static function insert($name, $data) {
            $len = count($data);
            $counter = 0;
            $row = "";
            $values = "";

            foreach($data as $key => $value) {
                $counter++;

                if($value !== NULL) {
                    if($len === 1) {
                        $row .= "(`$key`)";
                        $values .= "('$value')";
                    }
                    else if($counter === 1) {
                        $row .= "(`$key`,";
                        $values .= "('$value',";
                    }
                    elseif ($counter === $len) {
                        $row .= "`$key`)";
                        $values .= "'$value')";
                    }
                    else {
                        $row .= "`$key`,";
                        $values .= "'$value',";
                    }
                }
            }

            $query = "INSERT INTO $name $row VALUES $values";
            if(mysqli_query(self::$connect, $query)) {
                return true;
            }
            return false;
        }

        public static function select($name, $data, $where="") {
            $query = "SELECT $data FROM $name";
            if(!empty($where)) {
                $query .= " WHERE $where";
            }
            $result = mysqli_query(self::$connect, $query);
            if($result && mysqli_num_rows($result)) {
                return mysqli_fetch_all($result, MYSQLI_ASSOC);
            }
        }
    }
?>