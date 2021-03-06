<?php
use \Codeception\Stub;

class T2_userErrorTest extends \Codeception\Test\Unit {

    /**
     * @var $tester \UnitTester
     */
    protected $tester;
    protected $validUsername = 'BobRay';
    protected $invalidUsernameTooShort = 'Bo';
    protected $invalidUsernameTooLong =
        'asdasdadasdasdasdadasdssss';
    protected $validEmail = 'bobray@hotmail.com';
    protected $invalidEmail = 'bobrayhotmail.com';
    protected $validPhone = '218-456-2345';
    protected $invalidPhone = '218x123x2345';

    protected function _before() {
        require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/core/model/user2.class.php';
    }

    protected function _after() {
    }

    public function testWorking() {
        assertTrue(true);
    }

    /** @throws /Exception */
    public function testValidateUsername() {
        $user = Stub::makeEmptyExcept('User2', 'validateUsername');
        $result = $user->validateUsername($this->validUsername);
        assertTrue($result);
        $result = $user->validateUsername($this->invalidUsernameTooShort);
        assertFalse($result);
        $result = $user->validateUsername($this->invalidUsernameTooLong);
        assertFalse($result);
    }

    /** @throws /Exception */
    public function testValidateEmail() {
        $user = Stub::makeEmptyExcept('User2', 'validateEmail');
        $result = $user->validateEmail($this->validEmail);
        assertTrue($result);
        $result = $user->validateEmail($this->invalidEmail);
        assertFalse($result);
    }

    /** @throws /Exception */
    public function testValidatePhone() {
        $user = Stub::makeEmptyExcept('User2', 'validatePhone');
        $result = $user->validatePhone($this->validPhone);
        assertTrue($result);
        $result = $user->validatePhone($this->invalidPhone);
        assertFalse($result);
    }

    public function testAllValid() {
        $fields = array(
            'username' => $this->validUsername,
            'email' => $this->validEmail,
            'phone' => $this->validPhone,
        );
        $user = new User2($fields);
        assertFalse($user->hasErrors());
        $errors = $user->getErrors();
        assertEmpty($errors);
    }

    public function testBadUsernameWithConstructor() {
        /* Too Short */
        $fields = array(
            'username' => $this->invalidUsernameTooShort,
            'email' => $this->validEmail,
            'phone' => $this->validPhone,
        );
        $user = new User2($fields);
        assertTrue($user->hasErrors());
        $errors = $user->getErrors();
        assertNotEmpty($errors);
        assertEquals(1, count($errors));
        assertEquals('Invalid username', $errors[0], $errors[0]);

        /* Too long */
        $fields = array(
            'username' => $this->invalidUsernameTooLong,
            'email' => $this->validEmail,
            'phone' => $this->validPhone,
        );
        $user = new User2($fields);
        assertTrue($user->hasErrors());
        $errors = $user->getErrors();
        assertNotEmpty($errors);
        assertEquals(1, count($errors));
        assertEquals('Invalid username', $errors[0], $errors[0]);
    }

    public function testBadEmailWithConstructor() {
        $fields = array(
            'username' => $this->validUsername,
            'email' => $this->invalidEmail,
            'phone' => $this->validPhone,
        );
        $user = new User2($fields);
        assertTrue($user->hasErrors());
        $errors = $user->getErrors();
        assertNotEmpty($errors);
        assertEquals(1, count($errors));
        assertEquals('Invalid email', $errors[0], $errors[0]);
    }

    public function testBadPhoneWithConstructor() {
        $fields = array(
            'username' => $this->validUsername,
            'email' => $this->validEmail,
            'phone' => $this->invalidPhone,
        );
        $user = new User2($fields);
        assertTrue($user->hasErrors());
        $errors = $user->getErrors();
        assertNotEmpty($errors);
        assertEquals(1, count($errors));
        assertEquals('Invalid phone', $errors[0], $errors[0]);
    }
}