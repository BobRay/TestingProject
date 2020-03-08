<?php
use Codeception\Util\Fixtures;

class T7_FixtureTest extends \Codeception\Test\Unit
{
    /**  @var $tester IntegrationTester */
    protected $tester;

    /** @var modX $modx */
    public $modx;

    
    protected function _before()
    {
        $this->modx = Fixtures::get('modx');
        assertTrue($this->modx instanceof modX);
    }

    protected function _after()
    {

    }

    public function testWorking()
    {
        assertTrue(true);
        $docs = $this->modx->getCollection('modResource');
        assertNotEmpty($docs);
    }
}