<?php
/**
 * obtiene las boletas del cliente del usuario
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idUsuario=$_POST['idUsuario'];
    $idCliente =$_POST['idCliente'];
    $limiteInf = $_POST['limiteInf'];
    $limiteSup = $_POST['limiteSup'];

    $boletas = Usuario::getBoletas($idUsuario, $idCliente);

    if ($boletas) {
        print json_encode($boletas);
    } else {
        print json_encode(array('RESPUESTA' => 'ERROR BOLETA'));
    }
    }
    ?>