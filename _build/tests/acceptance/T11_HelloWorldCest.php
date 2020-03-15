<?php 

class T11_HelloWorldCest
{
      /**
     * @var \AcceptanceTester
     */
    public $I;

    protected function _before(\AcceptanceTester $I)
    {
    }

    protected function _after(\AcceptanceTester $I)
    {
    }

    // tests
    public function testSomeFeature(\AcceptanceTester $I)
    {
        $I->amOnPage('helloworld.html');
        $I->see('Hello World');
        $I->wait(3);
    }
}
