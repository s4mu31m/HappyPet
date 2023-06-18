<?php


$id = $_POST['product_id'];
// Carga todos los productos de products.json
$products = json_decode(file_get_contents('api.json'), true);

// Encuentra el producto con el ID proporcionado
$product = null;
foreach ($products as $p) {
  if ($p['id'] == $id) {
    $product = $p;
    break;
  }
}
require_once '../vendor/autoload.php';
require_once '../secrets.php';

\Stripe\Stripe::setApiKey($stripeSecretKey);
header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost:4242';

$checkout_session = \Stripe\Checkout\Session::create([
  'line_items' => [[
    'price' => $product['price_id'],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/success.html',
  'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
]);


header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
