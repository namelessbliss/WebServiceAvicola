<?php
/**
 * obtiene las boletas del cliente del usuario
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idUsuario=$_POST['idUsuario'];

    $fecha=$_POST['fecha'];

    $ventaDelDia = Usuario::cuadroUtilidades($idUsuario, $fecha);

    if ($ventaDelDia ) {

        print json_encode($ventaDelDia);

    } else {
        print json_encode(array('RESPUESTA' => 'ERROR OBTENER VENTA DIA'));
    
    }
    }
    ?>