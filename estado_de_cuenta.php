<?php
/**
 * obtiene las boletas del cliente del usuario
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idUsuario=$_POST['idUsuario'];

    $estadoCuenta = Usuario::estadoCuenta($idUsuario);

    if ($estadoCuenta) {
        print json_encode($estadoCuenta);
    } else {
        print json_encode(array('RESPUESTA' => 'ERROR ESTADO'));
    }
    }
    ?>