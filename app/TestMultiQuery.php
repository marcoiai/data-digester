<?php

use app\Http\Actions\customerAction;

include_once(__DIR__ . '/../bootstrap.php');
include_once('AutoLoader.php');

$client = new \GearmanClient();
$client->addServer();

//dd('teste');

// initialize the results of our 3 "query results" here
$userInfo = $friends = $posts = $customerUpdate = null;

// This sets up what gearman will callback to as tasks are returned to us.
// The $context helps us know which function is being returned so we can 
// handle it correctly.
$client->setCompleteCallback(function(\GearmanTask $task, $context) use (&$userInfo, &$friends, &$posts, &$customerUpdate) {
    switch($context) {
        case 'customerAdd':
            $userInfo = $task->data();
            break;
        case 'customerUpdate':
            $customerUpdate = $task->data();
            break;
        case 'customerFind':
            $friends = $task->data();
            break;
        case 'get_latest_posts_by':
            $posts = $task->data();
            break;
        case 'baconate':
            $friends = $task->data();
            break;
    }
});

$customerAction = new customerAction();

$updatePayload = $customerAction->generatePayload([
    'first_name' => 'Marco Teste ' . (new \DateTime('now'))->format('YmdHiss'),
    'last_name'  => 'Simon',
    'store_id'   => 2,
    'address_id' => 7,
    'email'      => 'marcoiai@hotmail.com.br',
    'active'     => 1,
]);

$updateWhere = ['customer_id' => 600];

$insertPayload = $customerAction->generatePayload([
    'first_name' => 'Marco Teste ' . (new \DateTime('now'))->format('YmdHiss'),
    'last_name'  => 'Simon',
    'store_id'   => 2,
    'address_id' => 7,
    'email'      => 'marcoiai@hotmail.com.br' . (new \DateTime('now'))->format('Hiss'),
    'active'     => 1,
]);

//dd($updatePayload);

// Here we queue up multiple tasks to be execute in *as much* parallelism as gearmand can give us
$client->addTask('customerUpdate', json_encode([$updatePayload, $updateWhere]), 'customerUpdate');
$client->addTask('customerAdd', json_encode($insertPayload), 'customerAdd');

for ($x = 6000; $x <= 12745; $x++)
{
    $updateWhere = ['customer_id' => $x];

    if ($x % 2 == 0) {
        $client->addTaskHighBackground('customerUpdate', json_encode([$updatePayload, $updateWhere]), 'customerUpdate');
    } else {
        $client->addTaskLowBackground('customerUpdate', json_encode([$updatePayload, $updateWhere]), 'customerUpdate');
    }
}

for ($c = 0; $c <= 1000; $c++)
{
    if ($c % 2 == 0) {
        $client->addTaskHigh('customerFind', '{}', 'customerFind');
    } else {
        $client->addTaskLow('customerFind', '{}', 'customerFind');
    }
}

//$client->addTask('baconate', 'joe@joe.com', 'baconate');
//$client->addTask('get_latest_posts_by', 'joe@joe.com', 'get_latest_posts_by');

/*
for ($c = 0; $c <= 1000; $c++)
{
    $client->addTask('customerAdd', json_encode($insertPayload), 'customerAdd');
    $client->addTask('customerAdd', json_encode($insertPayload), 'customerAdd');
    $client->addTask('customerAdd', json_encode($insertPayload), 'customerAdd');
    $client->addTask('customerAdd', json_encode($insertPayload), 'customerAdd');
    $client->addTask('customerAdd', json_encode($insertPayload), 'customerAdd');
    $client->addTask('customerAdd', json_encode($insertPayload), 'customerAdd');
}
    */

echo "\n📥 - Fetching...\n";
$start = microtime(true);
$client->runTasks();
$totaltime = number_format(microtime(true) - $start, 2);

echo "\n🕒 - Got user info in: $totaltime seconds:\n";
//var_dump($customerUpdate, $userInfo, $friends, $posts);
exit(0);