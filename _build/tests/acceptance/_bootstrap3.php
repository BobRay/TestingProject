<?php
use Codeception\Util\Fixtures;

require_once 'c:/xampp/htdocs/addons/vendor/autoload.php';
require_once 'c:/xampp/htdocs/addons/vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

require_once 'c:/xampp/htdocs/modx3/core/model/modx/modx.class.php';
echo "Getting MODX";
$modx = new modX();
$modx->getRequest();
$modx->getService('error', 'error.modError', '', '');
$modx->initialize('mgr');
Fixtures::add('modx', $modx);
$v = $modx->getVersionData();
$name = $v['full_appname'];
$isMODX3 = strpos($name, 'MODX Revolution 3') !== false;
assertTrue($isMODX3);
echo ' - ' . $name;