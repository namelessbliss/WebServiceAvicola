<?php
/**
 * elimina venta 
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idUsuario =$_POST['idUsuario'];
    $idCliente =$_POST['idCliente'];
    $idBoleta =$_POST['idBoleta'];


    $eliminarDetalle = Usuario::eliminarDetalleVenta($idCliente, $idBoleta);

    if ($eliminarDetalle) {

        $eliminarVenta = Usuario::eliminarVenta($idUsuario, $idCliente, $idBoleta);

        if ($eliminarVenta) {

            print json_encode(array('RESPUESTA' => 'COMPLETADO'));
        }else{

            print json_encode(array('RESPUESTA' => 'ERROR ELIMINAR DETALLE'));
        }
 		
    } else {
        print json_encode(array('RESPUESTA' => 'ERROR ELIMINAR VENTA'));
    }
    
    }
    ?>