<?php
namespace ConferenceScheduler;
class Autoloader {
    public static function init()
    {
        spl_autoload_register(function ($class) {
            $pathParams = explode("\\", $class);
            array_shift($pathParams);
            $path = implode(DIRECTORY_SEPARATOR, $pathParams);
            require_once $path . '.php';
        });


    }
}