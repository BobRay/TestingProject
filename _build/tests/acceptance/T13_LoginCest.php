<?php 

class T13_LoginCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    /** @throws Exception */
    public function tryToTest(AcceptanceTester $I)
    {
        /* Incorrect username */
        $I->amOnPage('manager');
        $I->fillField('#modx-login-username', 'XJoeTester');
        $I->fillField('#modx-login-password', 'TesterPassword');
        $I->click('#modx-login-btn');
        $I->see('The username or password you entered is incorrect. Please check the username, re-type the password, and try again.');

        /* Incorrect password */
        $I->amOnPage('manager');
        $I->fillField('#modx-login-username', 'JoeTester');
        $I->fillField('#modx-login-password', 'XTesterPassword');
        $I->click('#modx-login-btn');
        $I->see('The username or password you entered is incorrect. Please check the username, re-type the password, and try again.');

        /* Correct credentials */
        $I->fillField('#modx-login-username', 'JoeTester');
        $I->fillField('#modx-login-password', 'TesterPassword');
        $I->click('#modx-login-btn');
        $I->see('Content');
        $I->see('Manage');
        $I->dontSee('#modx-login-username');
        $I->dontSee('#modx-login-password');
    }
}
