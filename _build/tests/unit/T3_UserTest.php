<?php

use Codeception\Util\Stub;

class T3_UserTest extends \Codeception\Test\Unit {

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

    public function testConstructorWithArguments() {
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

    public function testConstructorNoArguments() {
        $user = new User3();
        assertEquals('', $user->get('username'));
        assertEquals('', $user->get('email'));
        assertEquals('', $user->get('phone'));
        assertFalse($user->hasErrors());
    }

    /** @throws Exception */
    public function testConstructorAllBad() {
        $stub =  $this->make(User3::class,
            array(
                'validateUsername' => function () {
                    return false;
                },
                'validateEmail' => function () {
                    return false;
                },
                'validatePhone' => function () {
                    return false;
                },
            ));

        $stub->__construct(array(
            'username' => 'Bobby',
            'email' => 'bob@hotmail.com',
            'phone' => '218-651-1234',
            'invalidField' => '',
        ));
        assertTrue($stub->hasErrors());
        $errors = $stub->getErrors();
        assertEquals(4, count($errors));
        assertContains('Invalid username', $errors);
        assertContains('Invalid email', $errors);
        assertContains('Invalid phone', $errors);
        assertContains('Unknown field', $errors);
    }

    /** @throws Exception */
    public function testConstructorAllGood() {
        $stub = $this->make(User3::class,
            array(
                'validateUsername' => function () {
                    return true;
                },
                'validateEmail' => function () {
                    return true;
                },
                'validatePhone' => function () {
                    return true;
                },

            ));

        $stub->__construct(array(
            'username' => 'Bobby',
            'email' => 'bob@hotmail.com',
            'phone' => '218-651-1234',
        ));
        assertFalse($stub->hasErrors());
        $errors = $stub->getErrors();
        assertEmpty($errors);
    }

        /** @throws Exception */
    public function testConstructorBadUsernameOnly() {

        $stub =  $this->make(User3::class,
            array(
                'validateUsername' => function () {
                    return false;
                },
                'validateEmail' => function () {
                    return true;
                },
                'validatePhone' => function () {
                    return true;
                }
            ));

        $stub->__construct(array(
            'username' => 'Bobby',
            'email' => 'bob@hotmail.com',
            'phone' => '218-651-1234'
        ));

        assertTrue($stub->hasErrors());
        $errors = $stub->getErrors();
        assertEquals(1, count($errors));
        assertContains('Invalid username', $errors);
    }


    /** @throws Exception */
    public function testConstructorBadEmailOnly() {

        $stub =  $this->make(User3::class,
            array(
                'validateEmail' => function () {
                    return false;
                },
                'validateUsername' => function () {
                    return true;
                },
                'validatePhone' => function () {
                    return true;
                },
            ));

        $stub->__construct(array(
            'username' => 'Bobby',
            'email' => 'bob@hotmail.com',
            'phone' => '218-651-1234'
        ));

        assertTrue($stub->hasErrors());
        $errors = $stub->getErrors();
        assertEquals(1, count($errors));
        assertContains('Invalid email', $errors);
    }

    /** @throws Exception */
    public function testConstructorBadPhoneOnly() {
        $stub =  $this->make(User3::class,
            array(
                'validateEmail' => function () {
                    return true;
                },
                'validateUsername' => function () {
                    return true;
                },
                'validatePhone' => function () {
                    return false;
                },
            ));

        $stub->__construct(array(
            'username' => 'Bobby',
            'email' => 'bob@hotmail.com',
            'phone' => '218-651-1234'
        ));

        assertTrue($stub->hasErrors());
        $errors = $stub->getErrors();
        assertEquals(1, count($errors));
        assertContains('Invalid phone', $errors);
    }

    /** @throws Exception */
    public function testConstructorUnknownFieldOnly() {

        $stub =  $this->make(User3::class,
            array(
                'validateEmail' => function () {
                    return true;
                },
                'validateUsername' => function () {
                    return true;
                },
                'validatePhone' => function () {
                    return true;
                },
            ));

        $stub->__construct(array(
            'username' => 'Bobby',
            'email' => 'bob@hotmail.com',
            'phone' => '218-651-1234',
            'invalidField' => '',
        ));

        assertTrue($stub->hasErrors());
        $errors = $stub->getErrors();
        assertEquals(1, count($errors));
        assertContains('Unknown field', $errors);
    }
}


