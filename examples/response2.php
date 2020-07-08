<?php

include __DIR__ . '/../vendor/autoload.php';

$number = 12345;
$response = new Irekk\Controller\Response;
$response->set('username', 'User #1');
$response->then(function($previous, $promise) use ($number) {
    print 'Hello ' . $promise->get('username') . PHP_EOL; // dynamic value
    print 'Your lucky number is ' . $number; // static value, value taken on moment of definition of callback function
});

// Now let's change values
$number = 12346;
$response->set('username', 'User #2');
$response->resolve();