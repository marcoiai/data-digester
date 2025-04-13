<html>
    <body>
        <?php
        include_once('AutoLoader.php');
        include_once('bootstrap.php');

        use app\Http\Actions\lookupUserAction;
use app\Http\Actions\UserAction;
use app\Model\ValueObject\CPFValueObject;
        use app\Model\ValueObject\CryptValueObject;
        use app\Model\ErrorHandling\handleExceptions;


        unset($_GET); // Just an ideia to avoid exploits
        unset($_POST); // Just an ideia to avoid exploits

        $request = $_SERVER['REQUEST_URI'];

        // Simulate .htaccess rewriting just for dev
        $request = str_ireplace('/tests.php', '', $request);
        $request = str_ireplace('/index.php', '', $request);
        
        switch ($request) {
            case '/add/user':
                $a = new UserAction();
                var_dump($a->getInstance(), $a->returnContract(), 'aoeueoau teste');

                echo '<br><br>';

                $a->first_name = 'teste';

                var_dump($a);
                //die("Action user add: " . __FILE__ . ": " . __LINE__);
            break;
       
            case '/update/user/':
               require __DIR__ . '/views/dep.php';
            break;

            case '/update/user/':
                require __DIR__ . '/views/dep.php';
             break;

             default:
                echo <<<HTML
                <h1>404 Error.</h1>
HTML;
             break;
       }

        $fn = function () {

            /** JSON ver como tratar, recebe rcertinho */
            $jsonData = file_get_contents('php://input');

            if ($jsonData) {
                \json_decode($jsonData, true);
            }
            
            /** 
             * JSON ver como tratar, recebe rcertinho 

            echo "Yeah Yeah!<br><br>";
            throw new \Exception('teste');

            $cpf = new CPFValueObject('035.637.729-67');

            $crypt = new CryptValueObject('testeKey');

            $encrypted = $crypt->encrypt($cpf);

            print_r($encrypted);

            var_dump($crypt->decrypt($encrypted));
            **/
        };

        $test = new handleExceptions($fn);

        echo <<<CSS
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <style>
            body {
                margin-top: 0;
                margin-left: 25px;
                margin-right: 25px;
                margin-bottom: 25px;
                background: url(/public/background-colored.jpg) #99f no-repeat fixed;
            }

            .error-stack-alert {
                text-shadow: -1px -1px red;
            }

            .errorShadow {
                text-shadow: -1px 2px red;
                opacity: 0.7;
            }
        </style>
CSS;
?>
    
    </body>
</html>