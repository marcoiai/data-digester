<?php
include_once(__DIR__ . '/app//Model/ErrorHandling/handleErrors.php');
include_once(__DIR__ . '/app//Model/ErrorHandling/handleAllExceptions.php');

use app\Model\ErrorHandling\handleExceptions;

set_exception_handler("handleAllExceptions");
set_error_handler("handleErrors");

//register_shutdown_function("shutDownFunction");

function shutDownFunction() {

    $errorFunction = function () { return error_get_last(); };

    new handleExceptions($errorFunction);

}

function dd(...$args)
{
    $info = debug_backtrace(!DEBUG_BACKTRACE_PROVIDE_OBJECT|DEBUG_BACKTRACE_IGNORE_ARGS, 2)[0];

    $aDate = new \DateTime('now');

    $data = json_encode($args);

    echo <<<BASH
            \033[1;31m 🪲  - DEBUG!\033[0m \n
BASH;

            echo "\t     \e[1;31m\e[104m ❗  - Data you asked for debug\e[0m\e[0m \n";

            echo <<<TXT
            \n
            \e[32m 📄  - File: {$info['file']}\e[0m

            \e[32m </>  - Line: {$info['line']}\e[0m

            \e[32m ƒ  - Function: {$info['function']}\e[0m

            \e[32m 📋  - Data: {$data}\e[0m

            \e[32m 🕓  - Time: {$aDate->format('d/m/Y H:i')}\e[0m
            \n
TXT;

    die();
}