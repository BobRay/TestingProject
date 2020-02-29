<?php

class T1_UserConstructorTest extends \Codeception\Test\Unit {
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before() {
        require_once 'c:/xampp/htdocs/addons/assets/mycomponents/testingproject/core/model/user1.class.php';
    }

    protected function _after() {
    }

    /* Tests */
    public function testWorking() {
        assertTrue(true);
    }

    public function testConstructorWithParams() {
        $user = new User1(array(
            'username' => 'BobRay',
            'email' => 'bobray@hotmail.com',
            'phone' => '651-423-1548'
        ));
        assertInstanceOf('User1', $user);
        assertEquals('BobRay', $user->get('username'));
        assertEquals('bobray@hotmail.com', $user->get('email'));
        assertEquals('651-423-1548', $user->get('phone'));
    }

    public function testConstructorNoParams() {
        $user = new User1();
        assertInstanceOf('User1', $user);
        assertEquals('', $user->get('username'));
        assertEquals('', $user->get('email'));
        assertEquals('', $user->get('phone'));
    }
}