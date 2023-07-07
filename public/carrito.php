<?php
session_start();
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
};
if (isset($_POST['cart'])) {
    $producto_id = $_POST['product_id'];
    $_SESSION['carrito'][] = $producto_id;
};
// * Crear Conexión con MongoDb
require '../public/mongo.php';
$client = connectMongoDB();

// * Buscar en la Base de Datos correspondiente
$db = $client->happypet;
$collection = $db->products;
// * Guardarlos en una Variable.
$cursor =$collection->find();
require "../partials/header.php";
require "../partials/navbar.php";


?>

<body>
    <div>
        <main class="productos">
            <?php foreach ($_SESSION['carrito'] as $producto_id) {
                    foreach ($cursor as $producto) {
                        if ($producto['id'] == $producto_id): ?>
                            <div class="product">
                            <?php

                            echo "<h2 class='titulo_producto'>" . $producto['title'] . "</h2>";
                            echo "<img class='imagen_producto' src='" . $producto['image'] . "' alt='Imagen del producto'>";
                            echo "<p class='descripcion_prodcuto'>" . $producto['description'] . "</p>";
                            echo "<p class='precio_producto'>Precio: " . $producto['price'] . "</p>";
                            echo "
                            <div class='selector-cantidad'>
                                <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-minus' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='#000000' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                                    <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                                    <path d='M5 12l14 0' />
                                </svg>
                                <input type='text' value='1' class='carrito-titulo_productos' disabled>
                                <svg xmlns='http://www.w3.org/2000/svg class='icon icon-tabler icon-tabler-plus' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='#000000' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                                    <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                                    <path d='M12 5l0 14' />
                                    <path d='M5 12l14 0' />
                                </svg>
                            </div>
                            <form method='post'>
                                <input type='hidden' name='remove_product_id' value='" . $producto['id'] . "'>
                                <button type='submit' name='remove' style='background: none; border: none; padding: 0; cursor: pointer;'>
                                    <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-trash-filled' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='#000000' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                                        <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                                        <path d='M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z' stroke-width='0' fill='currentColor' />
                                        <path d='M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z' stroke-width='0' fill='currentColor' />
                                    </svg>
                                </button>
                            </form>
                            ";
                            break;
                            ?> </div> <?php
                        endif;
                        }
                    }
                
            ?>
        </main>
    </div>







    <?php require "../partials/footer.php";
