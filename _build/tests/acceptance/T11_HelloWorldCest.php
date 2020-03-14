<?php 

class T11_HelloWorldCest
{
      /**
     * @var \AcceptanceTester
     */
    public $I;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature(\AcceptanceTester $I)
    {
        $I->amOnPage('helloworld.html');
        $I->see('Hello World');
    }
}
