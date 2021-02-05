<?php
use Codeception\Util\Fixtures;

class T13_LoginCest
{
    /** @var modX $modx */
    protected $modx;
    public function _before(AcceptanceTester $I)
    {
        // lexicon->load() crashes with no $_SESSION set
        $_SESSION['dummy'] = 'x';
        $this->modx = Fixtures::get('modx');
        $this->modx->lexicon->load('en:login');
    }

    // tests
    /** @throws Exception */
    public function testLogin(AcceptanceTester $I)
    {
        $errorMsg = $this->modx->lexicon('login_cannot_locate_account');
        $delay = 1;
        /* Incorrect username */
        $I->amOnPage('manager');
        $I->fillField('#modx-login-username', 'XJoeTester');
        $I->fillField('#modx-login-password', 'TesterPassword');
        $I->wait($delay);
        $I->click('#modx-login-btn');
        $I->see($errorMsg);
        $I->wait($delay);

        /* Incorrect password */
        $I->amOnPage('manager');
        $I->fillField('#modx-login-username', 'JoeTester');
        $I->fillField('#modx-login-password', 'XTesterPassword');
        $I->wait($delay);
        $I->click('#modx-login-btn');
        $I->see($errorMsg);
        $I->wait($delay);

        /* Correct credentials */
        $I->fillField('#modx-login-username', 'JoeTester');
        $I->fillField('#modx-login-password', 'TesterPassword');
        $I->wait($delay);
        $I->click('#modx-login-btn');
        $I->see('Content');
        $I->see('Manage');
        $I->dontSee('#modx-login-username');
        $I->dontSee('#modx-login-password');
        $I->dontSee($errorMsg);
        $I->wait($delay);
    }
}
