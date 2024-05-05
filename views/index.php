<?php

$config = new Config();
$request = new Request();


echo App::debug($config);


$start = $_SERVER['REQUEST_TIME_FLOAT'];

// Your PHP code here...

$end = microtime(true);
$executionTime = $end - $start;
echo "Execution time: " . $executionTime . " seconds";

print_r($request->get());


?>