<?php
include_once(__DIR__ . '/../bootstrap.php');
include_once('AutoLoader.php');

use app\Http\Actions\lookupUserAction;
use app\Model\ErrorHandling\handleExceptions;
use app\Model\PDOTest;

$worker = new \GearmanWorker();
$worker->addServer();

$worker->addFunction('lookup_user', function(\GearmanJob $job){
    // normally you'd so some very safe type checking and query binding to a database here.
    // ...and we're gonna fake that.\
    $payload = json_decode($job->workload(), true);
    //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $fn = new lookupUserAction();
    $a = $fn->getInstance();

    //new handleExceptions($fn);

    echo "Looking up user \n";
    sleep(3);
    return \json_encode($a->getAll());
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