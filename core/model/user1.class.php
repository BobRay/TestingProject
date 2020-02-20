<?php
    class User1 {
        protected $fields = array(
            'username' => '',
            'email' => '',
            'phone' => ''
        );

    /* Note that there are two underscores before the word "construct" */
    function __construct($properties = array()){
        if (!empty($properties)) {
            foreach ($properties as $key => $value) {
                if (array_key_exists($key, $this->fields )) {
                    $this->set($key, $value);
                }
            }
        }
    }

    public function set($fieldName, $value) {
        $this->fields[$fieldName] = $value;
    }
    public function get($fieldName) {
        if (array_key_exists($fieldName, $this->fields)) {
            return $this->fields[$fieldName];
        } else {
            return '';
        }
    }

    public function save($user) {
        return true;
    }
}