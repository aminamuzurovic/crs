<?php
require '../vendor/autoload.php';

Flight::register('db', 'PDO', array('mysql:host=localhost:81;dbname=bills','root',''));

Flight::route('GET /bills', function(){
    $bills = Flight::db()->query('SELECT * FROM bills', PDO::FETCH_ASSOC)->fetchAll();
    Flight::json($bills);
});

Flight::route('POST /bills', function(){
    $request = Flight::request()->data->getData();  
      $insert = "INSERT INTO bills (type, datetime, total_amount, status) VALUES(:type, :datetime, :total_amount, :status)";
      $stmt= Flight::db()->prepare($insert);
      $stmt->execute($request);
      Flight::json(['message' => "Bill ".$request['type']." has been added successfully"]);
});

Flight::route('DELETE /bill/@id', function($id){
  $query = "DELETE FROM bill WHERE id = :id";
  $stmt= Flight::db()->prepare($query);
  $stmt->execute(['id' => $id]);
  Flight::json(['message' => "Bill has been deleted successfully"]);
});

Flight::route('GET /count', function(){
  $count = Flight::db()->query('SELECT COUNT(DISTINCT(status)) AS status FROM bill GROUP BY status ', PDO::FETCH_ASSOC)->fetch();
  Flight::json($count);
});

/*Flight::route('GET /bills/@id', function($id){
  $query = "SELECT * FROM cars WHERE id = :id";
  $stmt= Flight::db()->prepare($query);
  $stmt->execute(['id' => $id]);
  $car = $stmt->fetch(PDO::FETCH_ASSOC);
  Flight::json($car);
});*/

Flight::start();
?>
