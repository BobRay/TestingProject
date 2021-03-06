<?php

    require_once 'validator.class.php';

    class User3 {
        protected $errors = array();
        protected $validator = null;
        protected $fields = array(
            'username' => '',
            'email' => '',
            'phone' => ''
        );

    function __construct($properties = array()){
        $this->validator = new Validator();
        if (!empty($properties)) {
            foreach ($properties as $key => $value) {
                $this->set($key, $value);
            }
        }
    }

    public function set($fieldName, $value) {
        $errorMsg = '';
        switch($fieldName) {
            case 'username':
                $valid = $this->validateUsername($value);
                $errorMsg = 'Invalid username';
                break;

            case 'email':
                $valid = $this->validateEmail($value);
                $errorMsg = 'Invalid email';
                break;

            case 'phone':
                $valid = $this->validatePhone($value);
                $errorMsg = 'Invalid phone';
                break;

            default:
                $valid = false;
                $errorMsg = 'Unknown field';

        }
        if ($valid === false) {
            $this->addError($errorMsg);
        } else {
            $this->fields[$fieldName] = $value;
        }
        return $valid;
    }
    public function get($fieldName) {
        if (array_key_exists($fieldName, $this->fields)) {
            return $this->fields[$fieldName];
        } else {
            $this->addError('Unknown Field: ' . $fieldName);
            return null;
        }
    }

    public function validateUsername($username) {
        return $this->validator->validateUsername($username);
    }

    public function validateEmail($email) {
        return $this->validator->validateEmail($email);
    }

    public function validatePhone($phone) {
        return $this->validator->validatePhone($phone);
    }

    public function save() {
        return true;
    }

    public function addError($error) {
        $this->errors[] = $error;
    }

    public function getErrors() {
        return $this->errors;
    }
    public function clearErrors() {
        $this->errors = array();
    }

    public function hasErrors() {
        return !empty($this->errors);
    }
}