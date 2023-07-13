<?php
require '../vendor/autoload.php';

use MongoDB\Client;

function connectMongoDB()
{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();


    $uri = $_ENV['MONGODB_URI'];
    $client = new Client($uri);

    return $client;
}
