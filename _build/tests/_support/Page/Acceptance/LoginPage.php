<?php
namespace Page\Acceptance;

class LoginPage
{
    // include url of current page
    public static $managerUrl = 'manager/';
    public static $usernameField = '#modx-login-username';
    public static $passwordField = '#modx-login-password';
    public static $username = 'JoeTester';
    public static $password = 'TesterPassword';
    public static $loginButton = '#modx-login-btn';
    public static $userMenu = '#modx-user-menu';
    public static $logoutLink = "//a[contains(@href,'?a=security/logout')]";
    public static $yesButton = "//button[contains(text(), 'Yes')]";

     /**
     * @var $tester \AcceptanceTester;
     */
    protected $tester;

    public function __construct(\AcceptanceTester $I)
    {
        /* Set $this->tester to passed-in $I so it's
            available in other methods */
        $this->tester = $I;
    }

    /** @throws \Exception */
    public function login($username = '', $password = '') {
        /** @var \AcceptanceTester $I */
        $I = $this->tester;
        $username = empty($username) ? self::$username : $username;
        $password = empty($password) ? self::$password : $password;

        $I->amOnPage(self::$managerUrl);
        $I->waitForElementVisible(self::$loginButton, 20);
        $I->waitForElementVisible(self::$usernameField,20);
        $I->fillField(self::$usernameField, $username);
        $I->fillField(self::$passwordField, $password);
        $I->click(self::$loginButton);
        return $this;
    }

    /** @throws \Exception */
    public function logout() {
        /** @var \AcceptanceTester $I */
        $I = $this->tester;
        $I->moveMouseOver(self::$userMenu);
        $I->waitForElementVisible(self::$logoutLink, 3);
        $I->click(self::$logoutLink);
        $I->wait(1);
        $I->click(self::$yesButton);
    }
}
