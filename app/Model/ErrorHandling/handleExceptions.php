<?php
namespace app\Model\ErrorHandling;

class handleExceptions {
    public function __construct($fn)
    {

        try {
            return $fn();
        } catch(\Exception $e) {
            $exploded = explode('#', $e->getTraceAsString());
            $imploded = implode("\n\n#", $exploded);

            $errorClass = get_class($e);

            echo <<<BASH
            \033[1;31m ⚠️  - AN ERROR HAS OCURRED!\033[0m \n
BASH;

            echo "\e[1;31m\e[104m ❗  - This Exception was caught: {$imploded}\e[0m\e[0m \n";

            $errorClass = get_class($e);

            echo <<<TXT
            \n
            \e[32m 📄  - File: {$e->getFile()}\e[0m

            \e[32m 📋  - Line: {$e->getLine()}\e[0m

            \e[32m 📋  - Error Message: {$e->getMessage()}\e[0m

            \e[32m 📋  - Classe do Erro: {$errorClass}\e[0m

            \e[32m 📋  - Error Code: {$e->getCode()}\e[0m
TXT;

        } catch (\Throwable $t) {
            $exploded = explode('#', $t->getTraceAsString());
            $imploded = implode('<br><br>#', $exploded);

            $errorClass = get_class($t);

        echo <<<BASH
        \033[1;31m ⚠️  - AN ERROR HAS OCURRED!\033[0m \n
BASH;

            echo "\e[1;31m\e[104m ❗  - This Exception was caught: {$imploded}\e[0m\e[0m \n",

            $trrorClass = get_class($t);

            echo <<<TXT
                \n
                \e[32m 📄  - File: {$t->getFile()}\e[0m

                \e[32m 📋  - Line: {$t->getLine()}\e[0m
            
                \e[32m 📋  - Error Message: {$t->getMessage()}\e[0m

                \e[32m 📋  - Classe do Erro: {$trrorClass}\e[0m

                \e[32m 📋  - Error Code: {$t->getCode()}\e[0m
TXT;
        }
    }
}