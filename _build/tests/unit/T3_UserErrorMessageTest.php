<?php

use Codeception\Util\Stub;

class T3_UserErrorMessageTest extends \Codeception\Test\Unit {

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before() {
        require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/core/model/user3.class.php';
    }

    protected function _after() {
    }

    public function testWorking() {
        assertTrue(true);
    }

    public function testConstructorWithParams() {
        $user = new User3(array(
            'username' => 'Robert',
            'email' => 'bobray@hotmail.com',
            'phone' => '218-456-1234'
        ));
        assertInstanceOf('User3', $user);
        assertEquals('Robert', $user->get('username'));
        assertEquals('bobray@hotmail.com', $user->get('email'));
        assertEquals('218-456-1234', $user->get('phone'));
        assertFalse($user->hasErrors());
    }

    public function testConstructorNoParams() {
        $user = new User3();
        assertEquals('', $user->get('username'));
        assertEquals('', $user->get('email'));
        assertEquals('', $user->get('phone'));
        assertFalse($user->hasErrors());
    }

    /** @throws Exception */
    public function testConstructorAllBad() {
        $user =  $this->make(User3::class,
            array(
                'validateUsername' => false,
                'validateEmail' => false,
                'validatePhone' => false,
            )
        );

        $user->__construct(array(
            'username' => 'Bobby',
            'email' => 'bob@hotmail.com',
            'phone' => '218-651-1234',
            'invalidField' => '',
        ));
        assertTrue($user->hasErrors());
        $errors = $user->getErrors();
        assertEquals(4, count($errors));
        assertContains('Invalid username', $errors);
        assertContains('Invalid email', $errors);
        assertContains('Invalid phone', $errors);
        assertContains('Unknown field', $errors);
    }

    /** @throws Exception */
    public function testConstructorAllGood() {
        $user = $this->make(User3::class,
          array(
            'validateUsername' => true,
            'validateEmail' => true,
            'validatePhone' => true,
          )
        );

        $user->__construct(array(
            'username' => 'Bobby',
            'email' => 'bob@hotmail.com',
            'phone' => '218-651-1234',
        ));
        assertFalse($user->hasErrors());
        $errors = $user->getErrors();
        assertEmpty($errors);
    }

        /** @throws Exception */
    public function testConstructorBadUsernameOnly() {

        $user =  $this->make(User3::class,
          array(
            'validateUsername' => false,
            'validateEmail' => true,
            'validatePhone' => true,
          )
        );

        $user->__construct(array(
            'username' => 'Bobby',
            'email' => 'bob@hotmail.com',
            'phone' => '218-651-1234'
        ));

        assertTrue($user->hasErrors());
        $errors = $user->getErrors();
        assertEquals(1, count($errors));
        assertContains('Invalid username', $errors);
    }


    /** @throws Exception */
    public function testConstructorBadEmailOnly() {

        $user =  $this->make(User3::class,
          array(
            'validateUsername' => true,
            'validateEmail' => false,
            'validatePhone' => true,
          )
        );

        $user->__construct(array(
            'username' => 'Bobby',
            'email' => 'bob@hotmail.com',
            'phone' => '218-651-1234'
        ));

        assertTrue($user->hasErrors());
        $errors = $user->getErrors();
        assertEquals(1, count($errors));
        assertContains('Invalid email', $errors);
    }

    /** @throws Exception */
    public function testConstructorBadPhoneOnly() {
        $user =  $this->make(User3::class,
          array(
            'validateUsername' => true,
            'validateEmail' => true,
            'validatePhone' => false,
          )
        );

        $user->__construct(array(
            'username' => 'Bobby',
            'email' => 'bob@hotmail.com',
            'phone' => '218-651-1234'
        ));

        assertTrue($user->hasErrors());
        $errors = $user->getErrors();
        assertEquals(1, count($errors));
        assertContains('Invalid phone', $errors);
    }

    /** @throws Exception */
    public function testConstructorUnknownFieldOnly() {

        $user =  $this->make(User3::class,
          array(
            'validateUsername' => true,
            'validateEmail' => true,
            'validatePhone' => true,
          )
        );

        $user->__construct(array(
            'username' => 'Bobby',
            'email' => 'bob@hotmail.com',
            'phone' => '218-651-1234',
            'invalidField' => '',
        ));

        assertTrue($user->hasErrors());
        $errors = $user->getErrors();
        assertEquals(1, count($errors));
        assertContains('Unknown field', $errors);
    }
}


