<?php
// Incluye el archivo que contiene la función connectMongoDB
require '../public/mongo.php';

// Crear conexión a MongoDB
$client = connectMongoDB();
// Seleccionar la base de datos y la colección donde quieras insertar los datos
$db = $client->happypet;
$collection = $db->products;

// Leer el archivo api.json
$json = file_get_contents(__DIR__ . '/api.json');

// Decodificar los datos JSON
$data = json_decode($json, true);


// Recorrer los datos y insertar cada uno en la base de datos
foreach ($data as $item) {
    $collection->insertOne($item);
}
