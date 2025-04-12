<?php

set_include_path(get_include_path() . ':' . substr($_SERVER['DOCUMENT_ROOT'], 0, strlen($_SERVER['DOCUMENT_ROOT']) -3 ));

spl_autoload_register(function($class_name) {
    try {
        include_once(str_replace('\\', '/', $class_name) . '.php');
    } catch(\Exception $e) {}
});

require_once('vendor/autoload.php');