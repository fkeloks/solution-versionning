<?php

define('EXECUTE_AS_INSTALLER', true);
require __DIR__ . DIRECTORY_SEPARATOR . 'index.php';

$controller = new \ESGI\Controllers\InstallController;
$controller->installAction();
