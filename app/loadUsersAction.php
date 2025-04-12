<?php
//loadUsersAction.php

//use app\Callable\JSONCallable;

$objects = [];

for ($x=0; $x <= 6; $x++)
{
    $obj = new \stdClass();
    $obj->name = "Teste Name $x";
    $obj->id = $x;
    $obj->date = new DateTime('now');

    $objects[] = $obj;
}

header('Content-Type: application/json');
http_response_code(200);
echo json_encode($objects);