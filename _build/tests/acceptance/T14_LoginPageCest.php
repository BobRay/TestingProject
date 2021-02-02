<?php
use Page\Acceptance\LoginPage;

class T14_LoginPageCest
{

    public function _before(\AcceptanceTester $I)
    {

    }

    // tests
    /** @throws \Exception */
    public function testLoginLogout(AcceptanceTester $I)
    {
        $I->wantTo('Log In');
        $loginPage = new LoginPage($I);
        $loginPage->login();
        $I->see('Content');
        $I->see('Manage');
        $loginPage->logout();
        $I->wait(2);
        $I->see('Password');
    }
}
