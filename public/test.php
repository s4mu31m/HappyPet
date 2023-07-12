<?php

// * Crear Conexión con MongoDb
require '../public/mongo.php';
$client = connectMongoDB();

// * Buscar en la Base de Datos correspondiente
$db = $client->happypet;
$collection = $db->products;
// * Guardarlos en una Variable.
$cursor = $collection->find();

foreach ($cursor as $producto) : ?>
    <a class="product-link" href="productos.php?id=<?php echo $producto->id; ?>">

        <div class="product">

            <?php

            echo "<h2 class='titulo_producto'>" . $producto->title . "</h2>";
            echo "<img class='imagen_producto' src='" . $producto->image . "' alt='Imagen del producto'>";
            echo "<p class='descripcion_prodcuto'>" . $producto->description . "</p>";
            echo "<p class='precio_producto'>Precio: " . $producto->price . "</p>";

            // Procesar la calificación
            $calificacion = round($producto->rating->rate);
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