<?php
session_start();
require "../database.php";
require 'cart_functions.php';
require '../public/mongo.php';
require "../partials/header.php";
require "../partials/navbar.php";

$client = connectMongoDB();
$db = $client->happypet;
$collection = $db->products;
$cursor = $collection->find();

$stmt = $conn->prepare("SELECT product_id FROM wishlist WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $_SESSION['user']['id']);
$stmt->execute();

$id_productos = $stmt->fetchAll(PDO::FETCH_COLUMN);

$wishlist_products = [];
foreach ($id_productos as $id_producto) {
  $product = $collection->findOne(['id' => $id_producto]);
  if ($product !== null) {
    $wishlist_products[] = $product;
  }
}

if (isset($_POST['cart'])) {
  addToCart($_POST['product_id']);
}

?>

<body>
  <div class="slider-frame"></div>
  <div>
    <main class="productos2">
      <?php foreach ($wishlist_products as $producto) : ?>
        <div class="product2">
          <img class='imagen_prodfav' src='<?= $producto['image'] ?>' alt='Imagen del producto'>
          <h2 class='titulo_prodfav'><?= $producto['title'] ?></h2>
          <p class='precio_prodfav'>Precio: <?= $producto['price'] ?></p>
          <p class='descripcion_prodfav'><?= $producto['description'] ?></p>
          <div class='estrellas2'><?= generateStars(round($producto['rating']['rate'])) ?></div>
          <div>
            <form method="POST">
              <input type="hidden" name="product_id" value="<?= $producto['id'] ?>">
              <button type="submit" name="cart" class="button-carrfav">Agregar al carrito de compra</button>
            </form>
            <form action="eliminarDeseos.php" method="POST">
              <input type="hidden" name="product_id" value="<?= $producto['id'] ?>">
              <button type="submit" id="checkout-button" class="button-fav">Eliminar</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </main>
  </div>
  <?php require "../partials/footer.php"; ?>
</body>

<?php
function generateStars($calificacion)
{
  $stars = '';
  for ($i = 1; $i <= 5; $i++) {
    $stars .= $calificacion >= $i ? "<span class='completa'></span>" : "<span></span>";
  }
  return $stars;
}
?>