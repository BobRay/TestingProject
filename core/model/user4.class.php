<?php

    class User4 {
        protected $errors = array();
        /** @var Validator $validator */
        protected $validator = null;
        protected $fields = array(
            'username' => '',
            'email' => '',
            'phone' => ''
        );

    function __construct($validator, $properties = array()){
        $this->validator = $validator;
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
                $valid = $this->validator->validateUsername($value);
                $errorMsg = 'Invalid username';
                break;

            case 'email':
                $valid = $this->validator->validateEmail($value);
                $errorMsg = 'Invalid email';
                break;

            case 'phone':
                $valid = $this->validator->validatePhone($value);
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