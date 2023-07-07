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

    <main class="productos2">

      <?php foreach ($wishlist_products as $producto) : ?>
        <a class="product-link" href="productos.php?id=<?php echo $producto['id']; ?>">
          <div class="product2">           
          

            <?php
            echo "<img class='imagen_prodfav' src='" . $producto['image'] . "' alt='Imagen del producto'>";
            echo "<h2 class='titulo_prodfav'>" . $producto['title'] . "</h2>";    
            echo "<p class='precio_prodfav'>Precio: " . $producto['price'] . "</p>";
            echo "<p class='descripcion_prodfav'>" . $producto['description'] . "</p>";
            
          

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
            <form action="checkout.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                    <button type="submit" id="checkout-button" class="button-fav">Eliminar</button>
            </form>
            </div>
          </div>    
           
             
            
          
          
        <?php endforeach; ?>
    </main>

  </div>

  <?php require "../partials/footer.php"; ?>