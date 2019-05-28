<?php

    class User {
        protected $errors = array();
        protected $fields = array();
        public $allowedFields = array('username', 'email', 'phone');

    function __construct($fields = array()){
        $x = 1;
        if (empty($fields)) {
            foreach ($this->allowedFields as $field) {
                $this->fields[$field] = '';
            }
        } else {
            foreach($fields as $key => $value) {
                if (in_array($key, $this->allowedFields)) {
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

    public function validatePhone($phone) {
        return true;
    }

    public function validateEmail($email) {
        return true;
    }

    public function register($fields = array()) {

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

    public function getAllowedFields() {
        return $this->allowedFields;
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