<?php
//use PHPUnit\Framework\TestCase;

require_once 'c:/xampp/htdocs/addons/vendor/autoload.php';

class userTest extends \Codeception\Test\Unit

// class userTest extends PHPUnit_Framework_TestCase
// class userTest extends TestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before() {
        require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/core/model/user.class.php';

    }

    protected function _after() {
    }

    // tests
    public function testWorking() {
        self::assertTrue(true);
    }

    public function testConstructorWithArguments() {
        $user = new User(array('username' => 'bob', 'email' => 'bobray@hotmail.com', 'phone' => '123'));
        self::assertInstanceOf('User', $user);
        self::assertEquals('bob', $user->get('username'));
        self::assertEquals('bob', $user->get('email'));
        self::assertEquals('123', $user->get('phone'));
        self::assertEquals(3, count($user->getFields()));
    }

    public function testConstructorNoArguments() {
        $user = new User();
        self::assertEquals('', $user->get('username'));
        self::assertEquals('', $user->get('email'));
        self::assertEquals('', $user->get('phone'));
        self::assertEquals(3, count($user->getFields()));
    }
}
