<?php

include __DIR__ . '/../vendor/autoload.php';

$response = new Irekk\Controller\Response;
$response->send('hello' . PHP_EOL);
$response->send('world' . PHP_EOL);
// this will trigger warning about headers being already sent
$response->headers([
    'content-type' => 'text/plain',
]);
$response->resolve();