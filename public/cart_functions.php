<?php
function addToCart($producto_id) {
    if (!isset($_SESSION)) {
        session_start();
    }

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    if (isset($_SESSION['carrito'][$producto_id])) {
        $_SESSION['carrito'][$producto_id]++;
    } else {
        $_SESSION['carrito'][$producto_id] = 1;
    }
}

function subtractFromCart($producto_id) {
    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_SESSION['carrito'][$producto_id]) && $_SESSION['carrito'][$producto_id] > 0) {
        $_SESSION['carrito'][$producto_id]--;
    } elseif (isset($_SESSION['carrito'][$producto_id]) && $_SESSION['carrito'][$producto_id] <= 0) {
        unset($_SESSION['carrito'][$producto_id]);
    }
}

function removeFromCart($producto_id) {
    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_SESSION['carrito'][$producto_id])) {
        unset($_SESSION['carrito'][$producto_id]);
    }
}
function add($producto_id) {
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }
    
    if (isset($_SESSION['carrito'][$producto_id])) {
        $_SESSION['carrito'][$producto_id]++;
    } else {
        $_SESSION['carrito'][$producto_id] = 1;
    }
}

?>
