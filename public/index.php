<?php
define('WEBROOT', str_replace("public/index.php", "", $_SERVER["SCRIPT_NAME"]));
define('ROOT', str_replace("public/index.php", "", $_SERVER["SCRIPT_FILENAME"]));

require(ROOT . 'bootstrap/Loader.php');

require(ROOT . 'Router.php');
require(ROOT . 'Request.php');
require(ROOT . 'Dispatcher.php');

$dispatch = new Dispatcher();
$dispatch->dispatch();
?>
