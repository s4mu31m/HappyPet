<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];  // Este es el ID del artículo al que se va a agregar el comentario
        $nombre = $_POST['nombre'];
        $mensaje = $_POST['mensaje'];

        // Lee el archivo JSON y lo convierte en un array de PHP
        $json = file_get_contents('api.json');
        $datos = json_decode($json, true);

        // Busca el artículo correspondiente por ID
        foreach ($datos as &$articulo) {
            if ($articulo['id'] == $id) {
                // Agrega el comentario al artículo
                $comentario = array(
                    'nombre' => $nombre,
                    'mensaje' => $mensaje
                );
                if (is_array($articulo['comments'])) {
                    $articulo['comments'][] = $comentario;
                } else {
                    $articulo['comments'] = array($comentario);
                }
                break;
            }
        }

        // Vuelve a escribir el archivo JSON con el comentario agregado
        $json = json_encode($datos);
        file_put_contents('api.json', $json);
    }
?>


