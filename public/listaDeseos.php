<?php

session_start();

require "../database.php";
$stmt = $conn->prepare("SELECT product_id FROM wishlist WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $_SESSION['user']['id']);
$stmt->execute();

$id_productos = $stmt->fetchAll(PDO::FETCH_COLUMN);
$json = file_get_contents('api.json');
$productos = json_decode($json,true);
$wishlist_products = array_filter($productos, function($product) use ($id_productos) {
  return in_array($product['id'], $id_productos);
});
require "../partials/header.php";

?>

<body>

  <?php require "../partials/navbar.php"; ?>

  <div class="slider-frame">

  </div>


  <div>

    <main class="productos">

      <?php foreach ($wishlist_products as $producto) : ?>
        <a class="product-link" href="productos.php?id=<?php echo $producto['id']; ?>">
          <div class="product">

            <?php

            echo "<h2 class='titulo_producto'>" . $producto['title'] . "</h2>";
            echo "<img class='imagen_producto' src='" . $producto['image'] . "' alt='Imagen del producto'>";
            echo "<p class='descripcion_prodcuto'>" . $producto['description'] . "</p>";
            echo "<p class='precio_producto'>Precio: " . $producto['price'] . "</p>";

            // Procesar la calificación
            $calificacion = round($producto['rating']['rate']);
            echo "<div class='estrellas'>";
            for ($i = 1; $i <= 5; $i++) {
              // Si el valor de calificación es mayor que o igual a $i, entonces esta estrella debe estar completa
              if ($calificacion >= $i) {
                echo "<span class='completa'></span>";
              } else {
                echo "<span></span>";
              }
            }
            echo "</div>";
            ?>
          </div>
        <?php endforeach; ?>
    </main>

  </div>

  <?php require "../partials/footer.php"; ?>