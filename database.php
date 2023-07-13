<?php

$host = "localhost";
$database = "happypet";
$user = "root";
$password = "123456";


try {
  $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);

} catch (PDOException $e) {
  die("PDO Connection Error: " . $e->getMessage());
}