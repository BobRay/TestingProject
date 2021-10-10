<?php
use Codeception\Util\Stub;
use \Codeception\Stub\Expected;

class T5_UserMockingTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $validator;
    protected $fields = array(
        'username' => 'BobRay',
        'email' => 'bobray@hotmail.com',
        'phone' => '218-456-1234'
    );

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
    public function testConstructorWithParams() {
        $validator = $this->make(Validator::class,
            array(
                'validateUsername' => Expected::once(true),
                'validateEmail' => Expected::once(true),
                'validatePhone' => Expected::once(true),
            )
        );
        $user = new User4($validator, $this->fields);
        assertInstanceOf('User4', $user);
        assertEquals('BobRay', $user->get('username'));
        assertEquals('bobray@hotmail.com', $user->get('email'));
        assertEquals('218-456-1234', $user->get('phone'));
        assertFalse($user->hasErrors());
    }

    /** @throws Exception */
    public function testConstructorNoParams() {
        $validator = $this->make(Validator::class, $this->fields);;
        $user = new User4($validator);
        assertEquals('', $user->get('username'));
        assertEquals('', $user->get('email'));
        assertEquals('', $user->get('phone'));
        assertFalse($user->hasErrors());
    }

    /** @throws Exception */
    public function testConstructorAllBad() {
        $validator = $this->make(Validator::class,
            array(
                'validateUsername' => Expected::once(false),
                'validateEmail' => Expected::once(false),
                'validatePhone' => Expected::once(false),
            )
        );
        $fields = $this->fields;
        $fields['invalidField'] = '';
        $user = new User4($validator, $fields);

        assertTrue($user->hasErrors());
        $errors = $user->getErrors();
        assertEquals(4, count($errors), print_r($errors, true));
        assertContains('Invalid username', $errors);
        assertContains('Invalid email', $errors);
        assertContains('Invalid phone', $errors);
        assertContains('Unknown field', $errors);
    }

    /** @throws Exception */
    public function testConstructorAllGood() {
        $validator = $this->make(Validator::class,
            array(
                'validateUsername' => Expected::once(true),
                'validateEmail' => Expected::once(true),
                'validatePhone' => Expected::once(true),
            )
        );

        $user = new User4($validator, $this->fields);

        assertFalse($user->hasErrors());
        $errors = $user->getErrors();
        assertEmpty($errors);
    }

    /** @throws Exception */
    public function testConstructorBadUsernameOnly() {

        $validator = $this->make(Validator::class,
            array(
                'validateUsername' => Expected::once(false),
                'validateEmail' => Expected::once(true),
                'validatePhone' => Expected::once(true),
            )
        );

        $user = new User4($validator, $this->fields);

        assertTrue($user->hasErrors());
        $errors = $user->getErrors();
        assertEquals(1, count($errors), print_r($errors, true));
        assertContains('Invalid username', $errors);
    }


    /** @throws Exception */
    public function testConstructorBadEmailOnly() {

        $validator = $this->make(Validator::class,
            array(
                'validateEmail' => Expected::once(false),
                'validateUsername' => Expected::once(true),
                'validatePhone' => Expected::once(true),
            )
        );

        $user = new User4($validator, $this->fields);


        assertTrue($user->hasErrors());
        $errors = $user->getErrors();
        assertEquals(1, count($errors), print_r($errors, true));
        assertContains('Invalid email', $errors);
    }

    /** @throws Exception */
    public function testConstructorBadPhoneOnly() {
        $validator = $this->make(Validator::class,
            array(
                'validateEmail' => Expected::once(true),
                'validateUsername' => Expected::once(true),
                'validatePhone' => Expected::once(false),
            )
        );

        $user = new User4($validator, $this->fields);

        assertTrue($user->hasErrors());
        $errors = $user->getErrors();
        assertEquals(1, count($errors), print_r($errors, true));
        assertContains('Invalid phone', $errors);
    }

    /** @throws Exception */
    public function testConstructorUnknownFieldOnly() {

        $validator = $this->make(Validator::class,
            array(
                'validateEmail' => Expected::once(true),
                'validateUsername' => Expected::once(true),
                'validatePhone' => Expected::exactly(1,true),
            )
        );

        $fields = $this->fields;
        $fields['invalidField'] = '';
        $user = new User4($validator, $fields);

        assertTrue($user->hasErrors());
        $errors = $user->getErrors();
        assertEquals(1, count($errors), print_r($errors, true));
        assertContains('Unknown field', $errors);
    }
}