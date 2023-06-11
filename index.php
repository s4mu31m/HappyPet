<?php


session_start();


// Leer el archivo JSON
$json = file_get_contents('api.json');

// Decodificar el JSON a un array de objetos PHP
$productos = json_decode($json);


?>





<?php require "./partials/header.php"; ?>



<body>

  <?php require "partials/navbar.php"; ?>
  

  <div>

    <main class="productos">
      <?php foreach ($productos as $producto) : ?>
        <div class="product">
          <?php
          echo "<h2 class='titulo_producto'>" . $producto->title . "</h2>";
          echo "<img class='imagen_producto' src='" . $producto->image . "' alt='Imagen del producto'>";
          echo "<p class='descripcion_prodcuto'>" . $producto->description . "</p>";
          echo "<p class='precio_producto'>Precio: " . $producto->price . "</p>";

          // Procesar la calificación
          $calificacion = round($producto->rating->rate);
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


  <?php require "./partials/footer.php"; ?>