<?php

require './vendor/autoload.php';

$client = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => '127.0.0.1',
    'port'   => 6379,
]);
$client->set('foo', 'bar');
$value = $client->get('foo');

print_r($value);

