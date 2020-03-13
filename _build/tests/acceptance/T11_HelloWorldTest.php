<?php 
class T11_HelloWorldTest extends \Codeception\Test\Unit
{
    /**
     * @var \AcceptanceTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $I = $this->tester;
        $I->amOnPage('helloworld.html');
        $I->see('Hello World');
    }
}