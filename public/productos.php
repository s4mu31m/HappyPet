<?php
session_start();
require "../partials/header.php";
require "../partials/navbar.php";

$id = $_GET['id']; // Obtiene el ID del producto del parámetro GET
// * Crear Conexión con MongoDb
require '../public/mongo.php';
$client = connectMongoDB();

// * Buscar en la Base de Datos correspondiente
$db = $client->happypet;
$collection = $db->products;
// * Guardarlos en una Variable.
$cursor =$collection->find();

// Encuentra el producto con el ID proporcionado
$product = null;
foreach ($cursor as $p) {
    if ($p['id'] == $id) {
        $product = $p;
        break;
    }
}


if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

if (isset($_POST['cart'])) {
    $producto_id = $_POST['product_id'];
    if (isset($_SESSION['carrito'][$producto_id])) {
        $_SESSION['carrito'][$producto_id] += 1;
    } else {
        $_SESSION['carrito'][$producto_id] = 1;
    }
}

if ($product) {
?>
    <link rel="stylesheet" href="style/productos.css" />

    <body>
        <script>
            function agregarComentario(event) {
                event.preventDefault();

                var id = document.getElementById('id_producto').value;
                var nombre = document.getElementById('nombre').value;
                var mensaje = document.getElementById('mensaje').value;

                var formData = new FormData();
                formData.append('id', id);
                formData.append('nombre', nombre);
                formData.append('mensaje', mensaje);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'guardar.php', true);
                xhr.onload = function() {
                    if (this.status == 200) {
                        alert('Comentario guardado exitosamente!');
                        document.getElementById('Formulario').reset();
                    } else {
                        alert('Hubo un problema al guardar el comentario. Por favor intenta de nuevo.');
                    }
                };
                xhr.send(formData);
            }
        </script>
        <main class="productos-pag">
            <div class="product-pag">
                <?php

                echo "<img class='imagen_producto-pag' src='" . $product['image'] . "'alt='Imagen del producto'>";

                ?>

            </div>

            <div class="detalles_producto">
                <?php echo "<h1 class ='titulo_producto-pag'>" . $product['title'] . "</h1>"; ?>
                <?php echo "<p>" . $product['resume'] . "</p>"; ?>
                <?php
                echo "<p class = 'precio_producto-pag'>Precio: " . $product['price'] . "</p>";
                $calificacion = round($product['rating']['rate']);
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
                <form action="checkout.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                    <button type="submit" id="checkout-button" class="button-orange">Comprar!</button>
                </form>
                <form action="wishlist.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                    <button type="submit" name="wishlist" class="button-orange">Agregar a la lista de deseos</button>
                </form>
                <form  method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                    <button type="submit" name="cart" class="button-orange">Agregar al carrito de compra</button>
                </form>
            </div>
            <div class="comments">
                <div id="comentarios"></div>
                <h3>Agregar comentario</h3>
                <form id="Formulario" onsubmit="agregarComentario(event)">
                    <input type="hidden" id="id_producto" value="<?php echo $id; ?>">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" required> <br>
                    <label for="mensaje">Mensaje:</label><br>
                    <textarea id="mensaje" required></textarea><br>
                    <button type="submit">Enviar comentario</button>
                </form>

            </div>
        </main>
    <?php

} else {
    // Si no se encontró el producto, muestra un mensaje de error
    echo "<p>Producto no encontrado.</p>";
}

require "../partials/footer.php";

    ?>