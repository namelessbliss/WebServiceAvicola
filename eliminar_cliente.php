<?php
/**
 * procesa venta y actualiza saldo
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idUsuario =$_POST['idUsuario'];
    $idCliente =$_POST['idCliente'];

    $eliminar = Usuario::eliminarCliente($idUsuario, $idCliente);

    if ($eliminar) {
             
        print json_encode(array('RESPUESTA' => 'COMPLETADO'));
        
    } else {
        print json_encode(array('RESPUESTA' => 'ERROR ELIMINAR CLIENTE'));
    }
    }
    ?>