<?php

session_start();



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
require "../partials/header.php";
require "../partials/navbar.php";


?>

<body>
    <div>
        <main class="productos2">
            <?php
            foreach ($_SESSION['carrito'] as $producto_id => $cantidad) {
                foreach ($productos as $producto) {
                    if ($producto['id'] == $producto_id) {
            ?>
                       
                            <div class="product3">
                                <?php
                                echo "<img class='imagen_prodfav' src='" . $producto['image'] . "' alt='Imagen del producto'>";
                                echo "<h2 class='titulo_prodfav'>" . $producto['title'] . "</h2>";
                                echo "<p class='precio_prodfav'>Precio: " . $producto['price'] . "</p>";
                                echo "<p class='descripcion_prodfav'>" . $producto['description'] . "</p>";

                                $calificacion = round($producto['rating']['rate']);
                                echo "<div class='estrellas'>";
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($calificacion >= $i) {
                                        echo "<span class='completa'></span>";
                                    } else {
                                        echo "<span></span>";
                                    }
                                }
                                echo "</div>";
                                ?>
                                
                                <div>
                                    <form action="selectorCantidad.php" method="POST">
                                        <input type="hidden" name="subtract" value="<?php echo $producto['id']; ?>">
                                        <button type="submit" class="button-carrfav2">
                                            <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-minus' width='24' height='22' viewBox='0 0 24 24' stroke-width='1.5' stroke='#ffffff' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                                                <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                                                <path d='M5 12h14' />
                                            </svg>
                                        </button>                                    
                                    </form>
                                    <form  action="selectorCantidad.php" method="POST">
                                        <input type="hidden" name="add" value="<?php echo $producto['id']; ?>">
                                        <button type="submit" class="button-carrfav3">
                                            <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-plus' width='24' height='24' viewBox='0 0 24 24' stroke-width='1.5' stroke='#ffffff' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                                                <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                                                <path d='M5 12h14m-7 -7v14' />
                                            </svg>
                                        </button>
                                    </form>
                                    <input type='text' value='<?php echo $cantidad; ?>' class='carrito-titulo_productos' disabled>
                                    <form  action="selectorCantidad.php" method="POST">
                                        <input type="hidden" name="remove_product_id" value="<?php echo $producto['id']; ?>">
                                        <button type="submit" name="remove" class="botelimi">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </a>
            <?php

                    }
                    
                }
            }

            ?>
        </main>


    </div>







    <?php require "../partials/footer.php";
