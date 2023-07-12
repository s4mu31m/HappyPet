<?php
require __DIR__.'/mongo.php';

// Ahora puedes llamar a la función
$client = connectMongoDB();
var_dump($client);
die();
