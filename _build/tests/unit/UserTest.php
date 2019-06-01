<?php
//use PHPUnit\Framework\TestCase;

use Codeception\Util\Stub;

// require_once 'c:/xampp/htdocs/addons/vendor/autoload.php';

class userTest extends \Codeception\Test\Unit

// class userTest extends PHPUnit_Framework_TestCase
// class userTest extends TestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before() {
       // require_once 'c:/xampp/htdocs/addons/vendor/autoload.php';
       // require_once 'c:/xampp/htdocs/addons/vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';
        require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/core/model/user.class.php';

    }

    protected function _after() {
    }

    // tests
    public function testWorking() {
        assertTrue(true);
    }

    public function testValidateEmail() {
        // $user = new User();
        /*$user = Stub::make('User', [
            'validateEmail' => function () {
                return true;
            }
        ]);*/
        $user = $this->getMockBuilder('emailValidator')->setMethods(array('validateEmail'))->getMock();
        // Create a stub for the SomeClass class.
        // Configure the stub.
        $user->method('validateEmail')
            ->willReturn(true);

        // Calling $stub->doSomething() will now return
        // 'foo'.
        $this->assertEquals($user->validateEmail('xxx'), true);

        assertEquals($user->validateEmail('xxx'), true);

       // self::assertTrue($user->validateEmail('xxx'));

    }

    public function testConstructorWithArguments() {
        $user = new User(array('username' => 'bob', 'email' => 'bobray@hotmail.com', 'phone' => '123'));
        self::assertInstanceOf('User', $user);
        self::assertEquals('bob', $user->get('username'));
        self::assertEquals('bobray@hotmail.com', $user->get('email'));
        self::assertEquals('123', $user->get('phone'));
        self::assertEquals(3, count($user->getFields()));
        self::assertFalse($user->hasErrors());
    }

    public function testConstructorNoArguments() {
        $user = new User();
        self::assertEquals('', $user->get('username'));
        self::assertEquals('', $user->get('email'));
        self::assertEquals('', $user->get('phone'));
        $fields = $user->getFields();
        self::assertEquals(3, count($fields), print_r($fields, true));
    }
}
