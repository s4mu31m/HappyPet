<?php
session_start();
require "../partials/header.php";

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

?>
<body>

  <?php require "../partials/navbar.php"; ?>
<!-- SLIDER -->
  <div class="slider-frame">

  </div>
  <!-- Slideshow container -->
  <div class="slideshow-container">

    <!-- Full-width images with number and caption text -->
    <div class="mySlides fade">
      <div class="numbertext">1 / 4</div>
      <img src="img\sliders\BANNER HAPPY PET.webp" style="width:100%">
      <div class="text"></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">2 / 4</div>
      <img src="img\sliders\BANNER HAPPY PET (1).webp" style="width:100%">
      <div class="text"></div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">3/ 4</div>
      <img src="img\sliders\BANNER HAPPY PET (2).webp" style="width:100%">
      <div class="text"></div>
    </div>
    <div class="mySlides fade">
      <div class="numbertext">4 / 4</div>
      <img src="img\sliders\BANNER HAPPY PET (3).webp" style="width:100%">
      <div class="text"></div>
    </div>


    <!-- Next and previous buttons -->
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
  </div>
  <br>

  <!-- The dots/circles -->
  <div style="text-align:center">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
    <span class="dot" onclick="currentSlide(4)"></span>


  </div>
  <script>
    let slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
      showSlides(slideIndex += n);
    }

    function currentSlide(n) {
      showSlides(slideIndex = n);
    }

    function showSlides(n) {
      let i;
      let slides = document.getElementsByClassName("mySlides");
      let dots = document.getElementsByClassName("dot");
      if (n > slides.length) {
        slideIndex = 1
      }
      if (n < 1) {
        slideIndex = slides.length
      }
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex - 1].style.display = "block";
      dots[slideIndex - 1].className += " active";
    }
  </script>

  <script>
    let slideIndex = 0;
    showSlides();

    function showSlides() {
      let i;
      let slides = document.getElementsByClassName("mySlides");
      let dots = document.getElementsByClassName("dot");
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      slideIndex++;
      if (slideIndex > slides.length) {
        slideIndex = 1
      }
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex - 1].style.display = "block";
      dots[slideIndex - 1].className += " active";
      setTimeout(showSlides, 2000); // Change image every 2 seconds
    }
  </script>
<!-- SLIDER -->
  <div>

    <main class="productos">

      <?php foreach ($productos as $producto) : ?>
        <a class="product-link" href="productos.php?id=<?php echo $producto ['id']; ?>">

          <div class="product">

            <?php

            echo "<h2 class='titulo_producto'>" . $producto['title'] . "</h2>";
            echo "<img class='imagen_producto' src='" . $producto ['image'] . "' alt='Imagen del producto'>";
            echo "<p class='descripcion_prodcuto'>" . $producto ['description'] . "</p>";
            echo "<p class='precio_producto'>Precio: " . $producto ['price'] . "</p>";

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