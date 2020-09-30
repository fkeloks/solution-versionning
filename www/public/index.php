<?php

use ESGI\Core\Application\Application;
use ESGI\Core\Autoloader\Autoloader;

define('START_TIME', microtime(true));

require __DIR__ . '/../helpers.php';
require __DIR__ . '/../Core/Autoload/Autoloader.php';

define('BASE_PATH', dirname(__DIR__));

// Autoloader
Autoloader::setBasePath(BASE_PATH);
Autoloader::setFirstNamespace('ESGI');

spl_autoload_register([Autoloader::class, 'loader']);

Application::boot();
