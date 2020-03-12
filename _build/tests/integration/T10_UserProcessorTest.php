<?php
use Codeception\Util\Fixtures;

class T10UserProcessorTest extends \Codeception\Test\Unit
{
    /**
     * @var \IntegrationTester
     */
    protected $tester;
    protected $processor;
    /** @var modX $modx */
    public $modx;
    protected $fields = array(
        'username' => 'Joe99',
        'password' => 'somepassword',
        'passwordnotifymethod' => 'x',
        'email' => 'joe99@hotmail.com',
    );


    protected function _before()
    {
        require_once 'C:/xampp/htdocs/test/core/model/modx/modProcessor.class.php';
        /* Get test file from dev. environment */
        require_once 'C:/xampp/htdocs/test/core/model/modx/processors/security/user/create.class.php';
        $this->modx = Fixtures::get('modx');
        assertInstanceOf('modX', $this->modx);

        $this->processor = modUserCreateProcessor::getInstance($this->modx,
            'modUserCreateProcessor', $this->fields);
        assertInstanceof('modUserCreateProcessor', $this->processor);
        $this->tester->removeUsers($this->modx, array('Joe99'));
    }

    protected function _after()
    {
        $this->tester->removeUsers($this->modx, array('Joe99'));
    }

    public function testClassKey() {
        $p = $this->processor;
        assertEquals('modUser', $p->classKey);
    }

    public function testInitialize()
    {
        /** @var modUserCreateProcessor $p */
        $p = $this->processor;
        $p->initialize();
        assertInstanceOf('modUser', $p->object);
        $props = array(
            'class_key' => 'modUser',
            'blocked' => false,
            'active' => false,
        );

        foreach ($props as $prop => $value) {
            assertEquals($value, $p->getProperty($prop));
        }

        $fields = array(
            'objectType' => 'user',
            'beforeSaveEvent' => 'OnBeforeUserFormSave',
            'afterSaveEvent' => 'OnUserFormSave',
        );
        foreach( $fields as $field => $value) {
            assertTrue($p->$field == $value);
        }
    }

    public function testBeforeSave() {
        /** @var modUserCreateProcessor $p */
        $p = $this->processor;
        $p->initialize();
        $result = $p->beforeSave();
        assertTrue($result, print_r($result, true));
        $object = $p->object;
        assertInstanceOf('modUser', $object);
        $username = $object->get('username');
        assertEquals('Joe99', $username);
        $profile = $object->getOne('Profile');
        assertInstanceOf('modUserProfile', $profile);
        $email = $profile->get('email');
        assertEquals('joe99@hotmail.com', $email);
    }

    public function testAddProfile() {
        /** @var modUserCreateProcessor $p */
        $p = $this->processor;
        $p->initialize();
        $profile = $p->addProfile();
        assertInstanceOf('modUserProfile', $profile);
        $object = $p->object;
        assertInstanceOf('modUser', $object);
        $profile = $object->getOne('Profile');
        assertInstanceOf('modUserProfile', $profile);
        $email = $profile->get('email');
        assertEquals('joe99@hotmail.com', $email);
    }

    public function testAfterSave() {
        $I = $this->tester;
        /** @var modUserCreateProcessor $p */
        $p = $this->processor;
        $p->initialize();
        $p->process();
        $result = $p->afterSave();
        assertTrue($result);
        $userTable = $this->_getTableName('modUser');
        $profileTable = $this->_getTableName('modUserProfile');
        $I->seeInDatabase($userTable, array('username' => 'Joe99'));
        $I->seeInDatabase($profileTable, array('email' => 'joe99@hotmail.com'));
    }

    /** Test full processor action with runProcessor() */
    public function testFull() {
        $I = $this->tester;
        $fields = $this->fields;
        /* Bypass MODX bug */
        $options = array('processors_path' => 'C:/xampp/htdocs/test/core/model/modx/processors/security/');
        $result = $this->modx->runProcessor('user/create', $fields, $options);
        assertInstanceOf('modProcessorResponse', $result);
        $userTable = $this->_getTableName('modUser');
        $profileTable = $this->_getTableName('modUserProfile');
        $I->seeInDatabase($userTable, array('username' => 'Joe99'));
        $I->seeInDatabase($profileTable, array('email' => 'joe99@hotmail.com'));
    }


    /**
     * Utility function to remove back-ticks from table name
     *
     * @param $class
     * @return string
     */
    public function _getTableName($class) {
        $tableName = $this->modx->getTableName($class);
        return str_replace('`', '', $tableName);
    }
}