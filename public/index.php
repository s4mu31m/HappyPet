<?php
session_start();
require '../public/mongo.php';
require "../partials/header.php";
require "../partials/navbar.php";

$client = connectMongoDB();
$db = $client->happypet;
$collection = $db->products;
$cursor = $collection->find();

?>

<body>
<!-- SLIDER   -->
  <div class="slider-frame"></div>
  <div class="slideshow-container">
    <?php
    $sliderImages = ["BANNER HAPPY PET.webp", "BANNER HAPPY PET (1).webp", "BANNER HAPPY PET (2).webp", "BANNER HAPPY PET (3).webp"];
    foreach ($sliderImages as $index => $image) : ?>
      <div class="mySlides fade">
        <div class="numbertext"><?= $index + 1 ?> / <?= count($sliderImages) ?></div>
        <img src="img\sliders\<?= $image ?>" style="width:100%">
        <div class="text"></div>
      </div>
    <?php endforeach; ?>

    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
  </div>

  <div style="text-align:center">
    <?php for ($i = 1; $i <= count($sliderImages); $i++) : ?>
      <span class="dot" onclick="currentSlide(<?= $i ?>)"></span>
    <?php endfor; ?>
  </div>

  <script>
    let slideIndex = 0;
    showSlides();

    function plusSlides(n) {
      showSlides(slideIndex += n);
    }

    function currentSlide(n) {
      showSlides(slideIndex = n);
    }

    function showSlides(n) {
      let slides = document.getElementsByClassName("mySlides");
      let dots = document.getElementsByClassName("dot");
      if (n !== undefined) {
        slideIndex = n > slides.length ? 1 : n < 1 ? slides.length : n;
      } else {
        slideIndex = ++slideIndex > slides.length ? 1 : slideIndex;
      }
      Array.from(slides).forEach(slide => slide.style.display = "none");
      Array.from(dots).forEach(dot => dot.className = dot.className.replace(" active", ""));
      slides[slideIndex - 1].style.display = "block";
      dots[slideIndex - 1].className += " active";
    }
  </script>
<!-- SLIDER -->
  <div>
    <main class="productos">
      <?php foreach ($cursor as $producto) : ?>
        <a class="product-link" href="productos.php?id=<?= $producto['id'] ?>">
          <div class="product">
            <h2 class='titulo_producto'><?= $producto['title'] ?></h2>
            <img class='imagen_producto' src='<?= $producto['image'] ?>' alt='Imagen del producto'>
            <p class='descripcion_prodcuto'><?= $producto['description'] ?></p>
            <p class='precio_producto'>Precio: <?= $producto['price'] ?></p>
            <div class='estrellas'><?= generateStars(round($producto['rating']['rate'])) ?></div>
          </div>
        </a>
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