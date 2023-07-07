<?php

session_start();

require "../database.php";
require "../public/mongo.php"; // Asume que este archivo incluye tu función `connectMongoDB()`

// Crear una nueva instancia de MongoDB\Client y conectar a tu base de datos y colección
$client = connectMongoDB();
$db = $client->happypet;
$collection = $db->products;

$stmt = $conn->prepare("SELECT product_id FROM wishlist WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $_SESSION['user']['id']);
$stmt->execute();

$id_productos = $stmt->fetchAll(PDO::FETCH_COLUMN);

$wishlist_products = [];
foreach ($id_productos as $id_producto) {
    // Buscar el producto en MongoDB usando el ID
    $product = $collection->findOne(['id' => $id_producto]);
    if ($product !== null) {
        // Si el producto existe, añadirlo a $wishlist_products
        $wishlist_products[] = $product;
    }
}

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
            <div>
            <form action="carrito.php" method="POST">
              <input type="hidden" name="product_id" value="<?php echo $id; ?>">
              <button type="submit" name="cart" class="button-carrfav">Agregar al carrito de compra</button>
            </form>
            <form action="eliminarDeseos.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $producto['id']; ?>">
                    <button type="submit" id="checkout-button" class="button-fav">Eliminar</button>
            </form>
            </div>
          </div>    
           
             
            
          
          
        <?php endforeach; ?>
    </main>

  </div>

  <?php require "../partials/footer.php"; ?>