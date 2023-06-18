<?php

$host = "localhost";
$database = "dbtvjyp9rumw5z";
$user = "uft9uqagbmpff";
$password = "}@$2#3_41s.+";

try {
  $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);

} catch (PDOException $e) {
  die("PDO Connection Error: " . $e->getMessage());
}
