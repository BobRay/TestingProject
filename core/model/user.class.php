<?php

    class User {
        protected $errors = array();
        protected $fields = array('username' => '', 'email' => '', 'phone' => '');
        protected $validator = null;

    function __construct($fields = array()){
        $x = 1;
        $this->validator = $this->getValidator();
        if (empty($fields)) {
            foreach ($this->fields as $key => $value) {
                $this->fields[$key] = '';
            }
        } else {
            foreach($fields as $key => $value) {
                if (key_exists($key, $this->fields)) {
                    $this->fields[$key] = $value;
                } else {
                    $this->addError('Invalid field: ' . $key);
                }

            }
        }

        return $this->hasErrors()
            ? null
            : $this;
    }

    public function getValidator() {
        return null;
    }
    public function validatePhone($phone) {
        return true;
    }

    public function validateEmail($email) {
        $validator = $this->validator();
        return $validator->validate('email', $email);
    }

    /* Process the User Registration Form */
    public function registerUser($fields = array()) {


    }
    public function get($fieldName) {
        return $this->fields[$fieldName];
    }

    public function getFields() {
        return $this->fields;
    }

    public function save($user) {
        return false;
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