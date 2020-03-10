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
        require_once 'c:/xampp/htdocs/test/core/model/modx/modProcessor.class.php';
        /* Get test file from dev. environment */
        require_once 'c:/xampp/htdocs/addons/core/model/modx/processors/security/user/create.class.php';
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

    public function testInit()
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
    }

    public function testAddProfile() {
        /** @var modUserCreateProcessor $p */
        $p = $this->processor;
        $p->initialize();
        $profile = $p->addProfile();
        assertInstanceOf('modUserProfile', $profile);
    }

    public function testAfterSave() {
        /** @var modUserCreateProcessor $p */
        $p = $this->processor;
        $p->initialize();
        $result = $p->afterSave();
        assertTrue($result);
    }

    public function testFull() {
        $fields = $this->fields;
//       $result = $this->modx->runProcessor('security/user/create', $fields);
//         assertInstanceOf('modProcessorResponse', $result);

    }
}