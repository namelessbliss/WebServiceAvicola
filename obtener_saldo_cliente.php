<?php
/**
 * obtiene las boletas del cliente del usuario
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idUsuario=$_POST['idUsuario'];
    $idCliente =$_POST['idCliente'];

    $saldo = Usuario::getSaldo($idUsuario, $idCliente);

    if ($saldo) {
        print json_encode($saldo+0);
    } elseif ($saldo == 0) {
        print json_encode(0);
    } else {
        print json_encode(array('RESPUESTA' => 'ERROR BOLETA'));
    }
    }
    ?>