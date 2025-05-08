<?php

function handleErrors(
    int $errno,
    string $errstr,
    string $errfile,
    int $errline,
) {
            echo <<<BASH
            \033[1;31m ⚠️  - AN ERROR HAS OCURRED!\033[0m \n
BASH;

            echo "\e[1;31m\e[104m ❗  - This Exception was caught: {$errstr}\e[0m\e[0m \n";

            echo <<<TXT
            \n
            \e[32m 📄  - File: {$errfile}\e[0m

            \e[32m 📋  - Line: {$errline}\e[0m

            \e[32m 📋  - Error Message: {$errstr}\e[0m

            \e[32m 📋  - Error Code: {$errno}\e[0m
TXT;
}
