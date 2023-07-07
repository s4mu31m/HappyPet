<?php
session_start();

// Incluir el archivo de la base de datos
include '../database.php';

// Comprobar si el usuario ha iniciado sesión
if(isset($_SESSION["user"])){
    // El usuario ha iniciado sesión. Eliminar el producto de la lista de deseos.
    removeFromWishlist($_SESSION['user']['id'], $_POST['product_id']);
} else {
    // El usuario no ha iniciado sesión. Redirigir a la página de inicio de sesión o mostrar una alerta.
    echo "<script type='text/javascript'>alert('Por favor, inicie sesión para eliminar artículos de su lista de deseos.'); 
    window.location.href = 'login.php';</script>";
}

function removeFromWishlist($userId, $productId) {
    global $conn; // Usar la conexión de la base de datos que ya has establecido
  
    // Preparar y vincular
    $stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = :user_id AND product_id = :product_id");
    
    // Comprobar si la preparación fue exitosa
    if ($stmt === false) {
      die("Error preparing statement: " . $conn->errorInfo()[2]);
    }
  
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':product_id', $productId);
  
    // Ejecutar la declaración
    $execute_result = $stmt->execute();
  
    // Comprobar si la ejecución fue exitosa
    if ($execute_result === false) {
      die("Error executing statement: " . $stmt->errorInfo()[2]);
    }
  
    // Cerrar la declaración y la conexión
    $stmt = null;
    $conn = null;
  }
  header("Location: index.php");
?>
