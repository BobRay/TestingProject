<?php

    class User2 {
        protected $errors = array();
        protected $fields = array(
            'username' => '',
            'email' => '',
            'phone' => ''
        );

    function __construct($properties = array()){
        if (!empty($properties)) {
            foreach ($properties as $key => $value) {
                $this->set($key, $value);
            }
        }
    }

    /**
     * Set a User field's value if the value is valid
     * @param string $fieldName -- name of the field
     * @param string $value -- value to set
     * @return bool true on success, false on failure
     */
    public function set($fieldName, $value) {

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

    /**
     * Return the value of a specific field
     * @param string $fieldName -- field to get
     * @return mixed|null -- return field value
     *    or null for unknown field
     */
    public function get($fieldName) {
        if (array_key_exists($fieldName, $this->fields)) {
            return $this->fields[$fieldName];
        } else {
            $this->addError('Unknown Field: ' . $fieldName);
            return null;
        }
    }

    /**
     * Validate username
     * @param string $username
     * @return bool -- true if valid, false if not
     */
    public function validateUsername($username) {
        return (bool)(
            (strlen($username) <= 25) &&
            (strlen($username) >= 3)
        );
    }

    /**
     * Validate email
     * @param string $email
     * @return bool -- true if valid, false if not
     */
    public function validateEmail($email) {
        return (bool) strpos($email, '@') !== false;
    }


    /**
     * Validate Phone number
     *
     * @param string $phone
     * @return bool -- true if valid, false if not
     */
    public function validatePhone($phone) {
        $pattern = '/^[0-9\-,.:]+$/';
        return (bool) preg_match($pattern, $phone);
    }

    /**
     * Save User object
     * @param $user
     * @return bool
     */
    public function save() {
        return true;
    }

    /**
     * Add an error to $this->errors
     * @param string $error
     */
    public function addError($error) {
        $this->errors[] = $error;
    }

    /**
     * Get full array of errors
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Clear all errors
     */
    public function clearErrors() {
        $this->errors = array();
    }

    /**
     * Report if there are any errors
     * @return bool -- true if errors, false if not
     */
    public function hasErrors() {
        return !empty($this->errors);
    }

}