<?php

$host = "localhost";
$database = "happypet";
$user = "root";
$password = "loky";


try {
  $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);

} catch (PDOException $e) {
  die("PDO Connection Error: " . $e->getMessage());
}