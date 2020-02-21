<?php



class ValidatorTest extends \Codeception\Test\Unit
{
    /** @var \UnitTester */
    /** @var Validator $validator */
    protected $validator;

    protected function _before()
    {
        require_once 'C:\xampp\htdocs\addons\assets\mycomponents\testingproject\core\model\validator.class.php';
        $this->validator = new Validator();
    }


    protected function _after()
    {
    }

    /**
     * @dataProvider usernameProvider
     * @param string $username
     * @param bool $expected
     */
    public function testUsernameValidator($username, $expected) {
        assertEquals($expected, $this->validator->validateUsername($username), $username);
    }

    /**
     * @dataProvider emailProvider
     * @param string $email
     * @param bool $expected
     */
    public function testEmailValidator($email, $expected) {
        assertEquals($expected, $this->validator->validateEmail($email), $email);
    }

    /**
     * @dataProvider phoneProvider
     * @param string $phone
     * @param bool $expected
     */
    public function testPhoneValidator($phone, $expected) {
        assertEquals($expected, $this->validator->validatePhone($phone), $phone);
    }

    public function usernameProvider() {
        return array(
            /* Valid */
            array('Bob', true),
            array('CaptainMarvel', true),

            /* Invalid */
            array('Bo', false),
            array('asdljkasdlkjasdlkjasldkjasldkjasldkjasldkjasldkjasldkjasldkjasdlkj', false),
        );
    }

    public function emailProvider() {
        /* Test Cases for validating email address */
        return array(
            /* Valid */
            array('simple@example.com', true),
            array('very.common@example.com', true),
            array('disposable.style.email.with+symbol@example.com', true),
            array('other.email-with-dash@example.com', true),
            array('fully-qualified-domain@example.com', true),
            array('x@example.com' , true),
            array('"very.unusual.@.unusual.com"@example.com', true),
            array('"very.(),:;<>[]\".VERY.\"very@\ \"very\".unusual"@strange.example.com', true),
            array('example-indeed@strange-example.com', true),
            array('/#!$%&\'*+-/=?^_`{}|~@example.org', true),
            array('example@s.solutions', true),
            array('user@[IPv6:2001:DB8::1]', true),

            /* Invalid */
            array('', false),
            array('Abc.example.com', false),
            array('A@b@c@example.com', false),
            array('a"b(c)d,e:f;gi[j\k]l@example.com', false),
            array('just"not"right@example.com', false),
            array('this is"not\allowed@example.com', false),
            array('this\ still\"not\allowed@example.com', false),
            array('1234567890123456789012345678901234567890123456789012345678901234+x@example.com',                   false),
            array('john..doe@example.com', false),
            array('john.doe@example..com', false),
            array('"much.more unusual"@example.com', false),
            array(' very.common@example.com', false),
            array('very.common@example.com ', false),
         );
    }

    public function phoneProvider() {
        /* Test Cases to validate
            USA phone number*/
        return array(
            /* valid */
            array('1-234-567-8901', true),
            array('+1-234-567-8901', true),
            array('651-321-1345', true),
            array('(651) 321-1345', true),
            array('1-234-567-8901 x1234', true),
            array('1-234-567-8901 ext1234', true),
            array('1-234-567-8901 extension 1234', true),
            array('1 (234) 567-8901', true),
            array('1.234.567.8901', true),
            array('12345678901', true),
            array('2345678901', true),

            /* Invalid */
            array('12345', false),
            array('1', false),
            array('123456', false),
            array('(213.123-4567', false),
            array('(xxx) xxx-xxxx', false),
            array('(123) 123-12345', false),
            array('(123) 1233-1234', false),
            array('(1234) 123-1234', false),
            array('911', false),
            array('411', false),
        );

    }
}