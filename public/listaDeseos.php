<?php

session_start();

require "../database.php";
require 'cart_functions.php';
//! En Main no se trabajará con mongo
// // * Crear Conexión con MongoDb
// require '../public/mongo.php';
// $client = connectMongoDB();

// // * Buscar en la Base de Datos correspondiente
// $db = $client->happypet;
// $collection = $db->products;
// // * Guardarlos en una Variable.
// $cursor =$collection->find();
//!---------------------------------

$productos = json_decode(file_get_contents("api.json"),true);

$stmt = $conn->prepare("SELECT product_id FROM wishlist WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $_SESSION['user']['id']);
$stmt->execute();

$id_productos = $stmt->fetchAll(PDO::FETCH_COLUMN);

//! En Main no se trabajará con mongo
// $wishlist_products = [];
// foreach ($id_productos as $id_producto) {
//     // Buscar el producto en MongoDB usando el ID
//     $product = $collection->findOne(['id' => $id_producto]);
//     if ($product !== null) {
//         // Si el producto existe, añadirlo a $wishlist_products
//         $wishlist_products[] = $product;
//     }
// }
//!---------------------------------

if (isset($_POST['cart'])) {
  addToCart($_POST['product_id']);
}

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
        
          <div class="product2">           
          

            <?php
            echo "<img class='imagen_prodfav' src='" . $producto['image'] . "' alt='Imagen del producto'>";
            echo "<h2 class='titulo_prodfav'>" . $producto['title'] . "</h2>";    
            echo "<p class='precio_prodfav'>Precio: " . $producto['price'] . "</p>";
            echo "<p class='descripcion_prodfav'>" . $producto['description'] . "</p>";
            
          

            // Procesar la calificación
            $calificacion = round($producto['rating']['rate']);
            echo "<div class='estrellas2'>";
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
            <form  method="POST">
              <input type="hidden" name="product_id" value="<?php echo $producto['id']; ?>">
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