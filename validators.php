<?php
    class Validator {
        private $errors = [];
        private $input;
        private $type;
        private $validators;
        
        // Path input to check
        public function make($input, $type, $validators) {
            $this->input = $input;
            $this->type = $type;
            $this->validators = explode("|", $validators);
            $this->validate();
        }

        // Manage validators
        public function validate() {
            foreach($this->validators as $validator) {
                $valid = explode(":", $validator);
                $message = "";
                
                switch ($valid[0]) {
                    case 'max':
                        $message = $this->maxLength(intval($valid[1]));
                        break;

                    case 'min':
                        $message = $this->minLength(intval($valid[1]));
                        break;

                    case 'required':
                        $message = $this->isRequired();
                        break;

                    case 'string':
                        $message = $this->isString();
                        break;

                    case 'numeric':
                        $message = $this->isNumeric();
                        break;

                    case 'not-numeric':
                        $message = $this->isNotNumeric();
                        break;

                    case 'email':
                        $message = $this->isEmail();
                        break;

                    case 'image':
                        $message = $this->isImage();
                        break;

                    case 'types':
                        $message = $this->imageTypes($valid[1]);
                        break;

                    case 'size':
                        $message = $this->maxSizeImage(intval($valid[1]));
                        break;

                    case 'confirm':
                        $message = $this->checkConfirmation($valid[1]);
                        break;
                    
                    default:
                        break;
                }

                if($message !== NULL) {
                    array_push($this->errors, $message);
                    break;
                }
            }
        }

        // All validators
        public function isRequired() {
            if(empty($this->input) || (isset($this->input["name"]) && empty($this->input["name"]))) return "* $this->type is required.";
        }

        public function isString() {
            if(!is_string($this->input))    return "* $this->type should be a string.";
        }

        public function isNumeric() {
            if(!is_numeric($this->input))    return "* $this->type should be a number.";
        }

        public function isNotNumeric() {
            if(is_numeric($this->input))    return "* $this->type should not be a number.";
        }

        public function isEmail() {
            if(!filter_var($this->input, FILTER_VALIDATE_EMAIL))    return "* Enter valid $this->type.";
        }

        public function isImage() {
            if($this->input["error"] !== 0)   return "Error while uploading the $this->type.";
        }

        public function maxLength($max) {
            if(strlen($this->input)>$max)  return "* Length of $this->type should be less than $max.";
        }

        public function minLength($min) {
            if(strlen($this->input)<$min)  return "* Length of $this->type should be greater than $min.";
        }

        public function imageTypes($validTypes) {
            $types = explode(",", $validTypes);
            $imagetype = pathinfo($this->input["name"], PATHINFO_EXTENSION);

            $imagetype = strtolower($imagetype);
            if(!in_array($imagetype, $types)) return "* Please enter image of type [$validTypes].";
        }

        public function maxSizeImage($max) {
            $size = $this->input["size"]/(1024*1024);
            if($size > $max) return "* Please enter $this->type with max size: $max Mb.";
        }

        public function checkConfirmation($confirm) {
            if($this->input !== $confirm)   return "* Wrong $this->type confirmation";
        }

        // getters
        public function getErrors() {
            return $this->errors;
        }
    }
?>