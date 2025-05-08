<?php
include_once(__DIR__ . '/../bootstrap.php');
include_once('AutoLoader.php');

use app\Http\Actions\customerAction;

unset($_GET); // Just an ideia to avoid exploits
unset($_POST); // Just an ideia to avoid exploits

$request = $_SERVER['REQUEST_URI'];

// Simulate .htaccess rewriting just for dev
$request = str_ireplace('/tests.php', '', $request);
$request = str_ireplace('/index.php', '', $request);

$fn = function () use($request) {

    /** JSON ver como tratar, recebe rcertinho */
    $jsonData = file_get_contents('php://input');

    if ($jsonData) {
        $decodedBody = \json_decode($jsonData, true);
    }

    switch ($request) {
        case '/customer/add':
            $addAction = new customerAction();
            
            $insert = $addAction->doInsert(
                $decodedBody
            );

            header('Content-Type: application/json');
            http_response_code(202);
            echo json_encode( ['data' => [
                'success' => true
            ]]);
            return;
        break;
    
        case '/customer/find':
            $findAction = new customerAction();

            header('Content-Type: application/json');
            http_response_code(202);
            echo json_encode($findAction->findAll(['first_name'], ['email' => 'marco.a.simao@gmail.com']));
            return;
        break;

        case '/user/update':
            require __DIR__ . '/views/dep.php';
            break;

            default:
            echo <<<HTML
            <h1>404 Error.</h1>
HTML;
            break;
    }
};

$fn();

//$test = new handleExceptions($fn);
