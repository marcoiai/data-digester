<?php
include_once(__DIR__ . '/app//Model/ErrorHandling/handleErrors.php');
include_once(__DIR__ . '/app//Model/ErrorHandling/handleAllExceptions.php');
use app\Model\ErrorHandling\handleExceptions;

set_exception_handler("handleAllExceptions");
//set_error_handler("handleErrors");

register_shutdown_function("shutDownFunction");

function shutDownFunction() {

    $errorFunction = function () { return error_get_last(); };

    new handleExceptions($errorFunction);

}