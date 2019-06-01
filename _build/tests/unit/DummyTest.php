<?php

class User {
    protected $errors = array();
    protected $fields = array('username' => '', 'email' => '', 'phone' => '');

    function __construct($fields = array()) {
        if (empty($fields)) {
            foreach ($this->fields as $key => $value) {
                $this->fields[$key] = '';
            }
        } else {
            foreach ($fields as $key => $value) {
                if (key_exists($key, $this->fields)) {
                    $this->fields[$key] = $value;
                }
            }
        }

        return $this->hasErrors()
            ? null
            : $this;
    }

    public function get($fieldName) {
        return $this->fields[$fieldName];
    }

    public function getFields() {
        return $this->fields;
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


class DummyTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testWorking()
    {
        assertTrue(true);
    }

    public function testConstructorWithArguments() {
        $user = new User(array('username' => 'bob', 'email' => 'bobray@hotmail.com', 'phone' => '123'));
        assertInstanceOf('User', $user);
        assertEquals('bob', $user->get('username'));
        assertEquals('bobray@hotmail.com', $user->get('email'));
        assertEquals('123', $user->get('phone'));
        assertEquals(3, count($user->getFields()));
        assertFalse($user->hasErrors());
    }

    public function testConstructorNoArguments() {
        $user = new User();
        assertEquals('', $user->get('username'));
        assertEquals('', $user->get('email'));
        assertEquals('', $user->get('phone'));
        $fields = $user->getFields();
        assertEquals(3, count($fields), print_r($fields, true));
    }
}