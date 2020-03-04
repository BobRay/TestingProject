<?php
namespace Helper;
use \modX;

class Integration extends \Codeception\Module

{
    /**  @var \modX $modx */
    public $modx;

    public function getModx() {
        require_once 'c:/xampp/htdocs/test/core/model/modx/modx.class.php';
        echo "Getting MODX";
        $this->modx = new modX();
        $this->modx->initialize('mgr');
        return $this->modx;
    }

}
