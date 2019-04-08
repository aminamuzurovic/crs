<?php
require '../vendor/autoload.php';

Flight::register('db', 'PDO', array('mysql:host=srv10.domenice.net;dbname=biznet_crs','biznet_crs','Z[&QT4jXw[{?'));

Flight::route('/', function(){
    echo 'hello world!';
});

Flight::route('GET /cars', function(){
    $cars = Flight::db()->query('SELECT * FROM cars', PDO::FETCH_ASSOC)->fetchAll();
    Flight::json($cars);
});

Flight::route('POST /cars', function(){
    $request = Flight::request()->data->getData();
    $insert = "INSERT INTO cars (name, power, year, fuel, ccm) VALUES(:name, :power, :year, :fuel, :ccm)";
    $stmt= Flight::db()->prepare($insert);
    $stmt->execute($request);
});

Flight::start();
?>
