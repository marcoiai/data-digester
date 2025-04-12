<?php

$worker = new \GearmanWorker();
$worker->addServer();

$worker->addFunction("c:func:log", function (\GearmanJob $job) {
  $workload = json_decode($job->workload());
  // Save the logs to the database, write them to a single file, index them, ship them to splunk, whatever
  printf(
      "Log line receieved - (%s @ %s) [%s] %s\n"
      , DateTime::createFromFormat(\DateTime::ATOM, $workload->ts, new \DateTimeZone('America/Sao_Paulo'))
      , $workload->host
      , $workload->level
      , json_encode($workload->message)
  );
  // You can do more interesting things too, like scan for specific errors
  // and send out warnings, or having rolling counts of errors to alert on, etc
});

while ($worker->work());