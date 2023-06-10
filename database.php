<?php

$host = "localhost";
$database = "c1551974_happet";
$user = "c1551974_happet";
$password = "wura90MAri";

try {
  $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);

} catch (PDOException $e) {
  die("PDO Connection Error: " . $e->getMessage());
}