<?php

namespace TDW;

use TDW\LIB\FrontController;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

require_once '..' . DS . 'app' . DS . 'config.php';
require_once APP_PATH . DS . 'lib' . DS . 'autoload.php';

session_start();

$frontController = new FrontController();
$frontController->dispatch();
