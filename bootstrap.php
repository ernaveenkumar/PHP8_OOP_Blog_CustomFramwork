<?php

declare(strict_types=1);

/*
First step here is to require this auto loading file generated by composer.
By including this file, I'm giving my app auto loading functionality automatically generated and handled

Now I can use classes from different namespaces.This is how you tell PHP.
It should load some class by just using a namespace or using a class from a namespace.
*/
require_once __DIR__ . '/vendor/autoload.php';

$config = require_once __DIR__ .'/config.php';

use Core\App;
use Core\Database;
use Core\ErrorHandler;

set_exception_handler([ErrorHandler::class, 'handleException']);
set_error_handler([ErrorHandler::class, 'handleError']);



App::bind('config', $config);
App::bind('database', new Database($config['database']));
