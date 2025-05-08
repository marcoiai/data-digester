<?php

function handleAllExceptions($e) {
    $exploded = explode('#', $e->getTraceAsString());
    $imploded = implode("\n\t#", $exploded);

    //echo debug_print_backtrace();

    echo <<<BASH
        \033[1;31m ⚠️  - AN ERROR HAS OCURRED!\033[0m \n
BASH;

    echo "\e[1;31m\e[104m ❗  - This Exception was caught: {$imploded}\e[0m\e[0m \n",

    $errorClass = get_class($e);

    echo <<<TXT
        \n
        \e[32m 📄  - File: {$e->getFile()}\e[0m

        \e[32m 📋  - Line: {$e->getLine()}\e[0m
    
        \e[32m 📋  - Error Message: {$e->getMessage()}\e[0m

        \e[32m 📋  - Classe do Erro: {$errorClass}\e[0m

        \e[32m 📋  - Error Code: {$e->getCode()}\e[0m
TXT;

    return false;
}