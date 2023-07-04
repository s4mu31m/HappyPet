<?php

$host = "localhost";
$database = "dbska6mdvq60wg";
$user = "uawfg7znhqn9z";
$password = ";6jc51(Sdgh2";

try {
  $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);

} catch (PDOException $e) {
  die("PDO Connection Error: " . $e->getMessage());
}