<?php
namespace Step\Acceptance;
use Codeception\Util\Fixtures;

class User extends \AcceptanceTester
{

    public function createUser()
    {
        $I = $this;

    }

    public function createUsers($modx)
    {
        $I = $this;
        assertTrue(true);
       // $modx = Fixtures::get('modx');
       //  assertTrue($modx instanceof modX);
        $doc = $modx->getObject('modResource', array('id' => '1'));
        assertNotEmpty($doc);
        $pt = $doc->get('pagetitle');
        assertEquals('Home', $pt);

    }

    public function removeUser()
    {
        $I = $this;
    }

    public function removeUsers($modx)
    {
        $I = $this;
        assertTrue(True);
    }

}