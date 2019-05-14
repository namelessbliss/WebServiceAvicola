<?php
/**
 * Obtiene todas las alumnos de la base de datos
 */

require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar petici�n GET
    $usuarios = Usuario::getAll();

    if ($usuarios) {

        $datos["estado"] = 1;
        $datos["alumnos"] = $usuarios;

        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

