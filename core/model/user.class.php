<?php

    require_once 'validator.class.php';

    class User {
        protected $errors = array();
        protected $validator = null;
        protected $fields = array(
            'username' => '',
            'email' => '',
            'phone' => ''
        );
        protected $required = array('username', 'email');


    function __construct($properties = array()){
        $this->validator = new Validator();
        if (!empty($properties)) {
            foreach ($properties as $key => $value) {
                $this->set($key, $value);
            }
        }

        foreach($this->required as $fieldName) {
            if (empty($this->fields[$fieldName])) {
                $this->addError('Field ' . $fieldName . ' is required');
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
                $errorMsg = 'Field Not Found';

        }
        if ($valid == false) {
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
            $this->addError('Unknown Field ' . $fieldName);
            return null;
        }
    }

    public function validatePhone($phone) {
        return Validator::validatePhone($phone);
    }

    public function validateEmail($email) {
        return Validator::validateEmail($email);
    }

        public function validateUsername($email) {
            return Validator::validateUsername($email);
        }

    /* Process the User Registration Form */
    public function registerUser($user) {
        /** @var User $user */
    }

    public function save($user) {
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