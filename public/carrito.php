<?php
session_start();
require "../partials/header.php";
require "../partials/navbar.php";
require '../public/cart_functions.php';
require '../public/mongo.php';

// * Crear Conexión con MongoDb
$client = connectMongoDB();
// * Buscar en la Base de Datos correspondiente
$db = $client->happypet;
$collection = $db->products;

// Check for actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['subtract'])) subtractFromCart($_POST['subtract']);
    if (isset($_POST['add'])) addToCart($_POST['add']);
    if (isset($_POST['remove'])) removeFromCart($_POST['remove_product_id']);
}

// Get the cart products
$cart_products = getCartProducts($collection, $_SESSION['carrito']);
?>

<body>
    <div>
        <main class="productos2">
            <?php
            foreach ($cart_products as $producto) {
                renderProduct($producto, $_SESSION['carrito'][$producto['id']]);
            }
            ?>
        </main>
    </div>

    <?php require "../partials/footer.php"; ?>


<?php
function getCartProducts($collection, $carrito) {
    // Prepare an array of product IDs
    $product_ids = array_keys($carrito);

    // Use the '$in' operator to get all products in one query
    $cursor = $collection->find(['id' => ['$in' => $product_ids]]);

    // Convert the cursor to an array for later use
    return $cursor->toArray();
}
function renderProduct($producto, $cantidad) {
    $calificacion = round($producto['rating']['rate']);
    $estrellas = generateStars($calificacion);
    
    echo <<<HTML
        <div class="product2">
            <img class='imagen_prodfav' src='{$producto['image']}' alt='Imagen del producto'>
            <h2 class='titulo_prodfav'>{$producto['title']}</h2>
            <p class='precio_prodfav'>Precio: {$producto['price']}</p>
            <p class='descripcion_prodfav'>{$producto['description']}</p>
            <div class='estrellas'>{$estrellas}</div>
            <div class='contenedor-botones'>
                <form method="POST">
                    <input type="hidden" name="subtract" value="{$producto['id']}">
                    <button type="submit" class="button-carrfav2">
                        <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-minus' width='24' height='22' viewBox='0 0 24 24' stroke-width='1.5' stroke='#ffffff' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                            <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                            <path d='M5 12h14' />
                        </svg>
                    </button>                                    
                </form>
                <form method="POST">
                    <input type="hidden" name="add" value="{$producto['id']}">
                    <button type="submit" class="button-carrfav3">
                        <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-plus' width='24' height='24' viewBox='0 0 24 24' stroke-width='1.5' stroke='#ffffff' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                            <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                            <path d='M5 12h14m-7 -7v14' />
                        </svg>
                    </button>
                </form>
                <input type='text' value='{$cantidad}' class='carrito-titulo_productos' disabled>
                <form method="POST">
                    <input type="hidden" name="remove_product_id" value="{$producto['id']}">
                    <button type="submit" name="remove" class="botelimi">Eliminar</button>
                </form>
                <form action ='checkout.php' method ="POST">
                    <input type="hidden" name="product_id" value="{$producto['id']}">
                    <button type="submit" class="button-pagar">Pagar</button>
                </form>
            </div>
        </div>
    HTML;
}

function generateStars($calificacion) {
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        $stars .= $calificacion >= $i ? "<span class='completa'></span>" : "<span></span>";
    }
    return $stars;
}