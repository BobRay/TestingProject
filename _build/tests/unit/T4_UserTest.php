<?php

use Codeception\Util\Stub;

class T4_UserTest extends \Codeception\Test\Unit {

    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $validator;

    protected function _before() {
        require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/core/model/user4.class.php';
        require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/core/model/validator.class.php';
    }

    protected function _after() {
    }

    public function testWorking() {
        assertTrue(true);
    }

    /** @throws Exception */
    public function testConstructorWithArguments() {
        $stub = $this->make(Validator::class,
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
        $user = new User4($stub, array(
            'username' => 'Robert',
            'email' => 'bobray@hotmail.com',
            'phone' => '218-456-1234'
        ));
        assertInstanceOf('User4', $user);
        assertEquals('Robert', $user->get('username'));
        assertEquals('bobray@hotmail.com', $user->get('email'));
        assertEquals('218-456-1234', $user->get('phone'));
        assertFalse($user->hasErrors());
    }

    /** @throws Exception */
    public function testConstructorNoArguments() {
        $stub = $this->make(Validator::class,
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

            ));;
        $user = new User4($stub);
        assertEquals('', $user->get('username'));
        assertEquals('', $user->get('email'));
        assertEquals('', $user->get('phone'));
        assertFalse($user->hasErrors());
    }

    /** @throws Exception */
    public function testConstructorAllBad() {
        $stub =  $this->make(Validator::class,
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

        $user = new User4($stub, array(
            'username' => 'Bobby',
            'email' => 'bob@hotmail.com',
            'phone' => '218-651-1234',
            'invalidField' => '',
        ) );

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
        $stub = $this->make(Validator::class,
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

        $user = new User4($stub, array(
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

        $stub =  $this->make(Validator::class,
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

        $user = new User4($stub, array(
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

        $stub =  $this->make(Validator::class,
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

        $user = new User4($stub, array(
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
        $stub =  $this->make(Validator::class,
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

        $user = new User4($stub, array(
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

        $stub =  $this->make(Validator::class,
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

        $user = new User4($stub, array(
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
