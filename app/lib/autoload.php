<?php
namespace TDW\LIB;

class AutoLoad {
    public static function autoload ($className) {
        // remove main namespace
        $className = str_replace('TDW','',$className);
        $className = strtolower($className);
        $className = str_replace('\\',DS,$className);
        $className .=  '.php';
        if(file_exists(APP_PATH.$className)){
            require_once APP_PATH.$className;
        }
    }
}

spl_autoload_register(__NAMESPACE__.'\AutoLoad::autoload');