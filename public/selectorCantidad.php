<?php
session_start();

if (isset($_POST['subtract'])) {
    $producto_id = $_POST['subtract'];
    if (isset($_SESSION['carrito'][$producto_id]) && $_SESSION['carrito'][$producto_id] > 0) {
        $_SESSION['carrito'][$producto_id]--;
    }elseif(isset($_SESSION['carrito'][$producto_id]) && $_SESSION['carrito'][$producto_id] <= 0){
        if (isset($_SESSION['carrito'][$producto_id])) {
            unset($_SESSION['carrito'][$producto_id]);
        }
    }
}

if (isset($_POST['add'])) {
    $producto_id = $_POST['add'];
    if (isset($_SESSION['carrito'][$producto_id])) {
        $_SESSION['carrito'][$producto_id]++;
    }
}

if (isset($_POST['remove'])) {
    $producto_id = $_POST['remove_product_id'];
    if (isset($_SESSION['carrito'][$producto_id])) {
        unset($_SESSION['carrito'][$producto_id]);
    }
}

header('Location: carrito.php');
?>

