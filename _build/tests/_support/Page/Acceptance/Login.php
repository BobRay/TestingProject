<?php
namespace Page\Acceptance;

class Login
{
    // include url of current page
    public static $managerUrl = 'manager/';
    public static $usernameField = '#modx-login-username';
    public static $passwordField = '#modx-login-password';
    public static $username = 'JoeTester';
    public static $password = 'TesterPassword';
    public static $loginButton = '#modx-login-btn';

     /**
     * @var $tester \AcceptanceTester;
     */
    protected $tester;

    public function __construct(\AcceptanceTester $I)
    {
        /* Set $this->tester to $I so it's available
           in other methods */
        $this->tester = $I;
    }

    public function login($username = '', $password = '') {
        /* @var \AcceptanceTester $I */
        $I = $this->tester;
        $username = empty($username) ? self::$username : $username;
        $password = empty($password) ? self::$password : $password;

        $I->amOnPage(self::$managerUrl);
        $I->fillField(self::$usernameField, $username);
        $I->fillField(self::$passwordField, $password);
        $I->click(self::$loginButton);
        return $this;
    }
}
