<?php
use Codeception\Util\Stub;

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
        assertTrue(true);
    }

    /** @throws Exception */
    public function _testValidateEmail() {
        // $user = new User();
        $user = Stub::make('User', array(), array(
            'validateEmail' => true,
        ));
        /*$user = $this->getMockBuilder('emailValidator')->setMethods(array('validateEmail'))->getMock();
        // Create a stub for the SomeClass class.
        // Configure the stub.
        $user->method('validateEmail')
            ->willReturn(true);

        // Calling $stub->doSomething() will now return
        // 'foo'.*/

        assertEquals(true, $user->validateEmail('xxx@') );

        assertTrue($user->validateEmail('xxx'));

    }

    public function testConstructorWithArguments() {
        $user = new User(array(
            'username' => 'bob',
            'email' => 'bobray@hotmail.com',
            'phone' => '218-456-1234'
        ));
        assertInstanceOf('User', $user);
        assertEquals('bob', $user->get('username'));
        assertEquals('bobray@hotmail.com', $user->get('email'));
        assertEquals('218-456-1234', $user->get('phone'));
        assertFalse($user->hasErrors());
    }

    /** @throws Exception */
    public function testConstructorBadEmailOnly() {
        /*$stub = $this->getMockBuilder('User')
            ->setMethods(array(
                'validateEmail',
                'validateUsername',
                'validatePhone'))
            ->disableOriginalConstructor()
            ->getMock();

       $stub->expects($this->any())
            ->method('validateEmail')
            ->will($this->returnValue(true));

        $stub->expects($this->any())
            ->method('validateUsername')
            ->will($this->returnValue(false));

        $stub->expects($this->any())
            ->method('validatePhone')
            ->will($this->returnValue(true));

        $stub->__construct(array(
            'username' => 'Bobby',
            'email' => 'bob@hotmail.com',
            'phone' => '218-651-1234'
        ));*/
        $stub =  $this->make(User::class, ['validateEmail' => function() { return false;},
            'validateUsername' => function() { return false;},
            'validatePhone' => function() { return false;}
            ]);

        $stub->__construct(array(
            'username' => 'Bobby',
            'email' => 'bob@hotmail.com',
            'phone' => '218-651-1234'
        ));



/* https://stackoverflow.com/questions/5546806/stubbing-a-method-called-by-a-class-constructor */
        assertTrue($stub->hasErrors());
//        assertTrue(false, print_r($stub->getErrors(), true));


    }

    public function testConstructorNoArguments() {
        $user = new User();
        assertEquals('', $user->get('username'));
        assertEquals('', $user->get('email'));
        assertEquals('', $user->get('phone'));
        assertNotEmpty($user->hasErrors());
        // assertTrue(false, print_r($user->getErrors(), true));
    }
}
