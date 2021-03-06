<?php
use Codeception\Util\Fixtures;

require_once 'c:/xampp/htdocs/addons/vendor/autoload.php';
require_once 'c:/xampp/htdocs/addons/vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

require_once 'c:/xampp/htdocs/test/core/model/modx/modx.class.php';
echo "Getting MODX";
$modx = new modX();
$modx->getRequest();
$modx->getService('error', 'error.modError', '', '');
$modx->initialize('mgr');
Fixtures::add('modx', $modx);