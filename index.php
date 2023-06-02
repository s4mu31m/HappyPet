<?php
require "./database.php";

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
    <header>
        <h1 class="titu">HappyPet</h1>
    </header>
    <div class="nav-bg">
        <nav class="navegacion-principal contenedor">

            <a href="">Inicio</a>
            <a href="">Nosotros</a>
            <a href="">Alimento</a>
            <a href="">Accesorios</a>
            <a href="">Contacto</a>
            <a href="">Mi Cuenta</a>

        </nav>
    </div>
    <section class="happy">
        <div class="contenido-happy">



        </div>
    </section>
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