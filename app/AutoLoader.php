<?php

set_include_path(get_include_path() . ':' . substr(__DIR__, 0, strlen(__DIR__) -3 ));

spl_autoload_register(function($class_name) {
    try {
        include_once(str_replace('\\', '/', $class_name) . '.php');
    } catch(\Exception $e) {}
});

require_once('vendor/autoload.php');