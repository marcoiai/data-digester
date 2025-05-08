<?php
include_once(__DIR__ . '/../bootstrap.php');
include_once('AutoLoader.php');

use app\Http\Actions\customerAction;

$worker = new \GearmanWorker();
$worker->addServer();

/**
 *  cli or cli-server, there other options
 */
if (php_sapi_name() === 'cli')
{
    echo "\n⚙️  -  Iniciando o Worker via CLI.\n";
} else {
    $request = $_SERVER['REQUEST_URI'];

    // Simulate .htaccess rewriting just for dev
    $request = str_ireplace('/tests.php', '', $request);
    $request = str_ireplace('/index.php', '', $request);

    /** JSON ver como tratar, recebe rcertinho */
    $jsonData = file_get_contents('php://input');

    if ($jsonData) {
        $payload = \json_decode($jsonData, true);
    }
}

$worker->addFunction('customerAdd', function(\GearmanJob $job) 
{
    $payload = json_decode($job->workload(), true);
    
    //print_r($payload);

    echo '🆕 ';

    //echo "\n🆕  -  customerAdd -> Inserindo usuário.\n";

    $addAction = new customerAction();
            
    $addAction->doInsert(
        $payload
    );

    //header('Content-Type: application/json');
    //http_response_code(202);
    return json_encode( ['data' => [
        'success' => true
    ]]);
});

$worker->addFunction('customerFind', function(\GearmanJob $job)
{
    $payload = json_decode($job->workload(), true);

    $action = new customerAction();

    echo '✅ ';

    //echo "🖥️  -  Looking up users \n";
    //sleep(3);
    return \json_encode($action->findAll(null, $payload));
});

$worker->addFunction('customerUpdate', function(\GearmanJob $job){
    // normally you'd so some very safe type checking and query binding to a database here.
    // ...and we're gonna fake that.\
    $payload = json_decode($job->workload(), true);

    echo '🔄 ';

    //echo "\n🆕  -  customerUpdate -> Atualizando usuário.\n";

    //dd(__FILE__, $payload[0], $payload[1]);

    $updateAction = new customerAction();
            
    $updateAction->update(
        $payload[0],
        $payload[1]
    );

    //header('Content-Type: application/json');
    //http_response_code(202);
    return json_encode( ['data' => [
        'success' => true
    ]]);

    //echo "🖥️ -  Updating users \n";
    //sleep(3);
    //return \json_encode($a);
});

$worker->addFunction('baconate', function(\GearmanJob $job){
    echo "Baconate user \n";
    sleep(3);
    return 'The user ('. $job->workload() .') is 1 degree away from Kevin Bacon';
});

$worker->addFunction('get_latest_posts_by', function(\GearmanJob $job){
    echo "Latests posts user \n";
    sleep(3);
    return 'The user ('. $job->workload() .') has no posts, sorry!';
});

while ($worker->work());