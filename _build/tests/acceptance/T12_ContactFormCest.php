<?php 

class T12_ContactFormCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I) {
    }

    // tests
    public function testContactForm(AcceptanceTester $I)
    {
        /* Submit empty form */
        $delay = 2;
        $I->amOnPage('contactform.html');
        $I->see('To contact us');
        $I->wait($delay);
        $I->click("#submit_button");
        $I->see('Name is required');
        $I->wait($delay);

        /* Submit form with name only */
        $I->amOnPage('contactform.html');
        $I->fillField("#user_name", 'BobRay');
        $I->wait($delay);
        $I->click("#submit_button");
        $I->see('Email is required');
        $I->wait($delay);

        /* Submit form with name and email only */
        $I->amOnPage('contactform.html');
        $I->fillField("#user_name", 'BobRay');
        $I->fillField("#user_email", 'bob@hotmail.com');
        $I->wait($delay);
        $I->click("#submit_button");
        $I->see('Message is required');
        $I->wait($delay);

        /* Submit with all fields filled */
        $I->amOnPage('contactform.html');
        $I->fillField("#user_name", 'BobRay');
        $I->fillField("#user_email", 'bob@hotmail.com');
        $I->fillField("#user_msg", 'Some Message');
        $I->wait($delay);
        $I->click("#submit_button");
        $I->see('Thank you');
        $I->wait($delay);
    }
}
