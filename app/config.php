<?php

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
define('APP_PATH', dirname(realpath(__FILE__)));
define('VIEWS_PATH', APP_PATH . DS . 'views' . DS);
define('PUBLIC_FOLDER',APP_PATH . DS .'..' . DS . 'public');
