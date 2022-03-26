<?php
    if($_SERVER["REQUEST_URI"] === "/Courses-ORG/validators.php")   echo "<script> window.location.href = 'index.php'; </script>";
    class Validator {
        private static $errors = [];
        private static $input;
        private static $type;
        private static $validators;
        
        // Path input to check
        public static function make($input, $type, $validators) {
            self::$input = $input;
            self::$type = $type;
            self::$validators = explode("|", $validators);
            Validator::validate();
        }

        // Manage validators
        public static function validate() {
            foreach(self::$validators as $validator) {
                $valid = explode(":", $validator);
                $message = "";
                
                switch ($valid[0]) {
                    case 'max':
                        $message = self::maxLength(intval($valid[1]));
                        break;

                    case 'min':
                        $message = self::minLength(intval($valid[1]));
                        break;

                    case 'required':
                        $message = self::isRequired();
                        break;

                    case 'string':
                        $message = self::isString();
                        break;

                    case 'numeric':
                        $message = self::isNumeric();
                        break;

                    case 'not-numeric':
                        $message = self::isNotNumeric();
                        break;

                    case 'email':
                        $message = self::isEmail();
                        break;

                    case 'image':
                        $message = self::isImage();
                        break;

                    case 'mimes':
                        $message = self::imageTypes($valid[1]);
                        break;

                    case 'size':
                        $message = self::maxSizeImage(intval($valid[1]));
                        break;

                    case 'confirm':
                        $message = self::checkConfirmation($valid[1]);
                        break;

                    case 'is-found':
                        $message = self::inTable($valid[1]);
                        break;
                    
                    default:
                        break;
                }

                if($message !== NULL) {
                    array_push(self::$errors, $message);
                    break;
                }
            }
        }

        // All validators
        public static function isRequired() {
            if(empty(self::$input) || (isset(self::$input["name"]) && empty(self::$input["name"]))) return "* " . self::$type . " is required.";
        }

        public static function isString() {
            if(!is_string(self::$input))    return "* " . self::$type . " should be a string.";
        }

        public static function isNumeric() {
            if(!is_numeric(self::$input))    return "* " . self::$type . " should be a number.";
        }

        public static function isNotNumeric() {
            if(is_numeric(self::$input))    return "* " . self::$type . " should not be a number.";
        }

        public static function isEmail() {
            if(!filter_var(self::$input, FILTER_VALIDATE_EMAIL))    return "* Enter valid " . self::$type . ".";
        }

        public static function isImage() {
            if(self::$input["error"] !== 0)   return "Error while uploading the " . self::$type . ".";
        }

        public static function maxLength($max) {
            if(strlen(self::$input)>$max)  return "* Length of " . self::$type . " should be less than $max.";
        }

        public static function minLength($min) {
            if(strlen(self::$input)<$min)  return "* Length of " . self::$type . " should be greater than $min.";
        }

        public static function imageTypes($validTypes) {
            $types = explode(",", $validTypes);
            $imagetype = pathinfo(self::$input["name"], PATHINFO_EXTENSION);

            $imagetype = strtolower($imagetype);
            if(!in_array($imagetype, $types)) return "* Please enter image of type [$validTypes].";
        }

        public static function maxSizeImage($max) {
            $size = self::$input["size"]/(1024*1024);
            if($size > $max) return "* Please enter " . self::$type . " with max size: $max Mb.";
        }

        public static function checkConfirmation($confirm) {
            if(self::$input !== $confirm)   return "* Wrong " . self::$type . " confirmation";
        }

        public static function inTable($table) {
            $result = Db::select($table, "id", "id = " . self::$input);
            if($result === NULL)    return"* Enter a valid " . self::$type . ".";
        }

        // getters
        public static function getErrors() {
            return self::$errors;
        }
    }
?>