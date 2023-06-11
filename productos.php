<?php
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
    // Si se encontró el producto, muestra su información
    echo "<h1>" . $product['title'] . "</h1>";
    echo "<p>" . $product['description'] . "</p>";
    echo "<p>Precio: $" . $product['price'] . "</p>";
} else {
    // Si no se encontró el producto, muestra un mensaje de error
    echo "<p>Producto no encontrado.</p>";
}
?>