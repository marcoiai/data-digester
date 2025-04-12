<?php
//loadUsersAction.php
include_once(__DIR__ . '/AutoLoader.php');
include_once(__DIR__ . '/../bootstrap.php');

use app\Callable\JSONCallable;
use app\Model\ErrorHandling\handleExceptions;

$users = [];

$fn = function () use ($users) {
    $users = new JSONCallable('http://localhost:9093/loadUsersAction.php');

    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode($users->getAll());
};

new handleExceptions($fn);
