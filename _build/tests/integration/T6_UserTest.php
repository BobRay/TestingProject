<?php 
class T6_UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    /** @var Validator $validator */
    protected $validator;
    protected $fields = array(
        'username' => 'BobRay',
        'email' => 'bobray@hotmail.com',
        'phone' => '218-456-1234'
    );
    
    protected function _before()
    {
        require_once 'C:\xampp\htdocs\addons\assets\mycomponents\testingproject\core\model\validator.class.php';
        require_once 'C:\xampp\htdocs\addons\assets\mycomponents\testingproject\core\model\user4.class.php';
        $this->validator = new Validator();
    }

    protected function _after()
    {
    }

    // tests
    public function testWorking()
    {
        assertTrue(true);
    }

    /**
     * @dataProvider errorDataProvider
     * @param string $username
     * @param string $email
     * @param string $phone
     * @param bool $hasErrors -- are errors expected?
     * @param int $count -- number of expected errors
     */

      public function testErrors($username, $email, $phone, $hasErrors, $count) {
          $fields = array(
             'username' => $username,
             'email' => $email,
             'phone' => $phone,
          );
          $user = new User4($this->validator, $fields);
          assertInstanceOf('User4', $user);
          $errors = $user->getErrors();
          if ($hasErrors) {
              assertTrue($user->hasErrors(), print_r($errors, true));
          } else {
              assertFalse($user->hasErrors(), print_r($errors, true));
          }
          assertEquals($count, count($errors));

          if (! $this->validator->validateUsername($username)) {
              assertContains('Invalid username', $errors, print_r($errors, true));
          }
          if (!$this->validator->validateEmail($email)) {
              assertContains('Invalid email', $errors, print_r($errors, true));
          }
          if (!$this->validator->validateUsername($phone)) {
              assertContains('Invalid phone', $errors, print_r($errors, true));
          }
      }

    /**
     * @dataProvider errorDataProvider
     * @param string $username
     * @param string $email
     * @param string $phone
     * @param bool $hasErrors -- are errors expected?
     * @param int $count -- number of expected errors
     */

      public function testUnknownField($username, $email, $phone, $hasErrors, $count) {
          $count++; /* add one for unknown field */
          $fields = array(
              'username' => $username,
              'email' => $email,
              'phone' => $phone,
              'unknown' => 'unknownField',
          );
          $user = new User4($this->validator, $fields);
          assertInstanceOf('User4', $user);
          $errors = $user->getErrors();
          assertNotEmpty($errors);
          assertEquals($count, count($errors));
          assertContains('Unknown field', $errors);
      }
    
    
    public function ErrorDataProvider() {
        $validUsername = 'BobRay';
        $invalidUsernameTooShort = 'Bo';
        $invalidUsernameTooLong =
            'asdasdadasdasdasdadasdssss';
        $validEmail = 'bobray@hotmail.com';
        $invalidEmail = 'bobrayhotmail.com';
        $validPhone = '218-356-2345';
        $invalidPhone = '218x123x2345';

        /* Array: username, email, phone, hasErrors, numErrors */
        return array(
            /* All valid */
            array($validUsername,$validEmail,$validPhone, false, 0),

            /* All invalid */
            array($invalidUsernameTooLong, $invalidEmail, $invalidPhone, true, 3),
            array($invalidUsernameTooShort, $invalidEmail, $invalidPhone, true, 3),

            /* Invalid username only */
            array($invalidUsernameTooShort, $validEmail, $validPhone, true, 1),
            array($invalidUsernameTooLong, $validEmail, $validPhone, true, 1),

            /* Invalid Email only */
            array($validUsername, $invalidEmail, $validPhone, true, 1),

            /* Invalid Phone only */
            array($validUsername, $validEmail, $invalidPhone, true, 1),

            /* Invalid username and invalid email */
            array($invalidUsernameTooLong, $invalidEmail, $validPhone, true, 2),
            array($invalidUsernameTooShort, $invalidEmail, $validPhone, true, 2),

            /* Invalid username and invalid phone */
            array($invalidUsernameTooLong, $validEmail, $invalidPhone, true, 2),
            array($invalidUsernameTooShort, $validEmail, $invalidPhone, true, 2),

            /* Invalid email and phone */
            array($validUsername, $invalidEmail, $invalidPhone, true, 2),
        );
    }
}