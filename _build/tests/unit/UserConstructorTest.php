<?php

class userTest extends \Codeception\Test\Unit {

    /**
     * @var $tester \UnitTester
     */
    protected $tester;

    protected function _before() {
        require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/core/model/user.class1.php';
    }

    protected function _after() {
    }

    // tests
    public function testWorking() {
        assertTrue(true);
    }

    public function testConstructorWithArguments() {
        $user = new User(array(
            'username' => 'BobRay',
            'email' => 'bobray@hotmail.com',
            'phone' => '218-456-1234'
        ));
        assertInstanceOf('User', $user);
        assertEquals('BobRay', $user->get('username'));
        assertEquals('bobray@hotmail.com', $user->get('email'));
        assertEquals('218-456-1234', $user->get('phone'));

    }

    public function testConstructorNoArguments() {
        $user = new User();
        assertEquals('', $user->get('username'));
        assertEquals('', $user->get('email'));
        assertEquals('', $user->get('phone'));
    }
}
