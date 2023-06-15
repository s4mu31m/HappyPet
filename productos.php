<?php

require "partials/header.php";
require "partials/navbar.php";

$id = $_GET['id']; // Obtiene el ID del producto del parámetro GET

// Carga todos los productos de products.json
$products = json_decode(file_get_contents('api.json'), true);

// Encuentra el producto con el ID proporcionado
$product = null;
foreach ($products as $p) {
    if ($p['id'] == $id) {
        $product = $p;
        break;
    }
}

if ($product) {
?>

    <body>
        <main class="productos-pag">
            <div class="product-pag">
                <?php
                echo "<h1 class ='titulo_producto-pag'>" . $product['title'] . "</h1>";
                echo "<img class='imagen_producto-pag' src='" . $product['image'] . "'alt='Imagen del producto'>";
                echo "<p class = 'precio_producto-pag'>Precio: $" . $product['price'] . "</p>";
                ?>
                
            </div>

            <div class="detalles_producto">
                <h2 class="Description">Descripcion</h2>
                <?php
                echo "<p>" . $product['description'] . "</p>";
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
            </div>
            <div class="comments">
                <h2>Comentarios</h2>
                <div id="comentarios"></div>
                <h3>Agregar comentario</h3>
                <form id="Formulario" onsubmit="agregarComentario(event)">
                    <label for="nombre">Nombre</label>
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

require "partials/footer.php";

    ?>