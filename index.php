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
  <section class="principal">

    <article class=" presentacion">

      <h1>Bienvenidos a happy pet!!!</h1>

      <p>Tienda virtual con despacho a domicilio.</p>


      <a href=""><button type="button" class="btn btn-light" style="margin-left: 20px; border-radius: 30px; width: 200px;">Comprar</button></a>
      <a href=""><button type="button" class="btn btn-light" style="margin-left: 20px; border-radius: 30px; width: 200px;">Ver Todo</button></a>



      <img src="" alt="">
    </article>

    <article class="redes-img">

      <a href=""><i class="fa-brands fa-facebook fa-2xl" style="color: #f2f2f2;"></i></a>
      <a href=""><i class="fa-brands fa-twitter fa-2xl" style="color: #f2f2f2;"></i></a>
      <a href=""><i class="fa-brands fa-instagram fa-2xl" style="color: #f2f2f2;"></i></a>

    </article>

  </section>


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