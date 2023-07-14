<?php
session_start();
require "../partials/header.php";
require "../partials/navbar.php";
require 'cart_functions.php';

// * Crear Conexión con MongoDb
require '../public/mongo.php';
$client = connectMongoDB();

$db = $client->happypet;
$collection = $db->products;

$cursor = $collection->find();

$id = $_GET['id']; 

$product = null;
foreach ($cursor as $p) {
    if ($p['id'] == $id) {
        $product = $p;
        break;
    }
}

if (isset($_POST['cart'])) {
    addToCart($_POST['product_id']);
}

if (!$product) {
    echo "<p>Producto no encontrado.</p>";
    exit();
}
?>

<link rel="stylesheet" href="style/productos.css" />

<body>
<!-- COMENTARIOS     -->
    <script>
        function agregarComentario(event) {
            event.preventDefault();

            let id = document.getElementById('id_producto').value;
            let nombre = document.getElementById('nombre').value;
            let mensaje = document.getElementById('mensaje').value;

            let formData = new FormData();
            formData.append('id', id);
            formData.append('nombre', nombre);
            formData.append('mensaje', mensaje);

            let xhr = new XMLHttpRequest();
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
<!-- COMENTARIOS     -->

    <main class="productos-pag">
        <div class="product-pag">
            <img class='imagen_producto-pag' src='<?= $product['image'] ?>' alt='Imagen del producto'>
        </div>

        <div class="detalles_producto">
            <h1 class ='titulo_producto-pag'><?= $product['title'] ?></h1>
            <p><?= $product['resume'] ?></p>
            <p class = 'precio_producto-pag'>Precio: <?= $product['price'] ?></p>

            <?php
            $calificacion = round($product['rating']['rate']);
            echo "<div class='estrellas'>";
            for ($i = 1; $i <= 5; $i++) {
                echo $calificacion >= $i ? "<span class='completa'></span>" : "<span></span>";
            }
            echo "</div>";
            ?>
            
            <form action="checkout.php" method="POST">
                <input type="hidden" name="product_id" value="<?= $id ?>">
                <button type="submit" id="checkout-button" class="button-orange">Comprar!</button>
            </form>
            
            <form action="wishlist.php" method="POST">
                <input type="hidden" name="product_id" value="<?= $id ?>">
                <button type="submit" name="wishlist" class="button-orange">Agregar a la lista de deseos</button>
            </form>
            
            <form  method="POST">
                <input type="hidden" name="product_id" value="<?= $id ?>">
                <button type="submit" name="cart" class="button-orange">Agregar al carrito de compra</button>
            </form>
        </div>
        
        <div class="comments">
            <div id="comentarios"></div>
            <h3>Agregar comentario</h3>
            <form id="Formulario" onsubmit="agregarComentario(event)">
                <input type="hidden" id="id_producto" value="<?= $id ?>">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" required> <br>
                <label for="mensaje">Mensaje:</label><br>
                <textarea id="mensaje" required></textarea><br>
                <button type="submit">Enviar comentario</button>
            </form>

        </div>
    </main>

<?php
require "../partials/footer.php";
?>
