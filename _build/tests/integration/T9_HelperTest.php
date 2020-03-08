<?php
use Codeception\Util\Fixtures;

class T9_HelperTest extends \Codeception\Test\Unit
{
    /**  @var $tester IntegrationTester */
    protected $tester;

    /** @var modX $modx */
    public $modx;

    protected $usernames = array(
        'User1','User2',
    );
    
    protected function _before()
    {
        $this->modx = Fixtures::get('modx');
        assertTrue($this->modx instanceof modX);
        $this->tester->removeUsers($this->modx, $this->usernames);
    }

    protected function _after()
    {
        $this->tester->removeUsers($this->modx, $this->usernames);
    }

    // tests
    public function testWorking()
    {
        $I = $this->tester;
        assertTrue(true);
        $I->dontSeeInDatabase('modx_users', array('username' => 'User1'));
        $I->dontSeeInDatabase('modx_users', array('username' => 'User2'));
    }

    public function testSaveUser() {
        /** @var @var modUser $user */
        $I = $this->tester;
        $user = $this->modx->newObject('modUser');
        $user->set('username', 'User1');
        assertTrue($user->save());
        $I->seeInDatabase('modx_users', array('username' => 'User1'));
    }

    public function testUpdateUser() {
        $I = $this->tester;
        $I->dontSeeInDatabase('modx_users', array('username' => 'User1'));
        $I->dontSeeInDatabase('modx_users', array('username' => 'User2'));
        $user = $this->modx->newObject('modUser');
        $user->set('username', 'User1');
        assertTrue($user->save());
        $I->seeInDatabase('modx_users', array('username' => 'User1'));
        $user = $this->modx->getObject('modUser', array('username' => 'User1'));
        assertNotEmpty($user);
        assertInstanceOf('modUser', $user);

        $user->set('username', 'User2');
        assertTrue($user->save());
        $I->dontSeeInDatabase('modx_users', array('username' => 'User1'));
        $I->seeInDatabase('modx_users', array('username' => 'User2'));
    }

    public function testDeleteUser() {
        $I = $this->tester;
        $I->dontSeeInDatabase('modx_users', array('username' => 'User1'));
        $user = $this->modx->newObject('modUser');
        $user->set('username', 'User1');
        assertTrue($user->save());
        $I->seeInDatabase('modx_users', array('username' => 'User1'));
        $user->remove();
        $I->dontSeeInDatabase('modx_users', array('username' => 'User1'));
    }
}