<?php

require './vendor/autoload.php';

/*
$client = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => '127.0.0.1',
    'port'   => 6379,
]);
$client->set('foo', 'bar');
$value = $client->get('foo');
print_r($value);
*/

/*
$client->hset("categories", "1", "deneme123");
$client->hset("categories", "2", "deneme321");

$value = $client->hgetall("categories");
print_r($value);

exit;
*/
try {
    $db = new PDO("mysql:host=localhost;dbname=redis", "root", "");
} catch ( PDOException $e ){
    print $e->getMessage();
}

$client = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => '127.0.0.1',
    'port'   => 6379,
]);


if (!$client->exists('categories')) {
    $query = $db->prepare("SELECT * FROM  categories");
    $query->execute();
    $categories = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($categories as $value) {
        $client->hset("categories", $value['id'], $value['name']);
    }
}else {
    $cache = $client->hgetall("categories");
    $i=0;
    foreach ($cache as $key => $value) {
        $categories[$i]['id']=$key;
        $categories[$i++]['name']=$value;
    }
}

echo '<pre>';
print_r($categories);

