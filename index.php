<?php


session_start();




$service_url = 'https://fakestoreapi.com/products';
$curl = curl_init($service_url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Añade esta línea

$response = curl_exec($curl);

if ($response === false) {
    $info = curl_getinfo($curl);
    curl_close($curl);
    die('Ocurrió un error: ' . var_export($info));
}

curl_close($curl);

$products = json_decode($response);
$randomProduct = $products[array_rand($products)]; // Selecciona un producto aleatorio
?>





<?php require "./partials/header.php"; ?>

<body>
    <?php if (isset($_SESSION["user"])) : ?>
        <div class="p-2">
            <?= $_SESSION["user"]["email"] ?>
        </div>
    <?php endif ?>
    <body>
    <header>
      <div class="icon-principal">
        <i class="fa-solid fa-bone fa-2xl" style="margin-top: 15px; margin-right: 5px;"></i>
        <span class="texto">Happy pet</span>
      </div>
        <ul class="enlaces">
          <li><a href="">Inicio</a></li>          
          <li> <a href="">Productos</a></li>           
          <li> <a href="">Favoritos</a></li>  
          <li> <a href=""><i class="fa-sharp fa-solid fa-cart-shopping fa-xl"></i></a></li>
          <li> <a href=""><i class="fa-solid fa-right-to-bracket fa-xl" style="color: #ffffff;"></i></a></li>            
        </ul>
    </header>

    <section class="principal">

    <article class=" presentacion">

      <h1>Bienvenidos a happy pet!!!</h1>

      <p>Tienda virtual con despacho a domicilio.</p>
       

      <a href=""><button type="button" class="btn btn-light" style="margin-left: 20px; border-radius: 30px; width: 200px;">Comprar</button></a>
      <a href=""><button type="button" class="btn btn-light" style="margin-left: 20px; border-radius: 30px; width: 200px;" >Ver Todo</button></a>


   
      <img src="" alt=""> 
    </article>

     <article class="redes-img">

      <a href=""><i class="fa-brands fa-facebook fa-2xl" style="color: #f2f2f2;"></i></a>
      <a href=""><i class="fa-brands fa-twitter fa-2xl" style="color: #f2f2f2;"></i></a>
     <a href=""><i class="fa-brands fa-instagram fa-2xl" style="color: #f2f2f2;"></i></a>
      
     </article>
   
   </section>

    <section class="animales">


      <div class="perros">
        <i class="fa-solid fa-dog"></i>
        <a href=""><button type="button" class="btn btn-light" style="margin-left: 20px; border-radius: 30px; width: 200px;">Comprar</button></a>
      </div>

      <div class="gatos">
        <i class="fa-solid fa-dog"></i>
        <a href=""><button type="button" class="btn btn-light" style="margin-left: 20px; border-radius: 30px; width: 200px;">Comprar</button></a>
      </div>
    </section>ion>
    <div>

        <main class="productos">
            <?php foreach ($products as $product) : ?>
                <div class="product">
                    <?php
                    echo "<h2 class ='titulo_producto'>" . $product->title . "</h2>";
                    echo "<img class ='imagen_producto' src='" . $product->image . "' alt='Imagen del producto'>";
                    echo "<p class ='descripcion_prodcuto'>" . $product->description . "</p>";
                    echo "<p class ='precio_producto'>Precio: " . $product->price . "</p>";
                    ?>
                </div>
            <?php endforeach; ?>
        </main>

    </div>


    <?php require "./partials/footer.php"; ?>