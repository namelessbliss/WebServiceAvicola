<?php
/**
 * procesa venta y actualiza saldo
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data=$_POST['arrayVenta'];
    $idUsuario =$_POST['idUsuario'];
    $idCliente =$_POST['idCliente'];
    $idBoleta =$_POST['idBoleta'];
    $new_array=json_decode($data,true);
    //print_r($data);

    $subtotal = 0;

    foreach($new_array as $row)
            {
                $subtotal = $subtotal + $row['total'];
            }
            //echo "subtotal : ".$subtotal;
    $actualizar = Usuario::actualizarVenta($idUsuario, $idCliente, $idBoleta, $subtotal);

    if ($actualizar) {

       $actualizarDetalle = Usuario::actualizarDetalleVenta($idBoleta, $idCliente, $new_array);

       if ($actualizarDetalle) {

        print json_encode(array('RESPUESTA' => 'COMPLETADO'));

       }else{

        print json_encode(array('RESPUESTA' => 'ERROR DETALLE'));

       }       
        
    } else {

        print json_encode(array('RESPUESTA' => 'ERROR BOLETA'));
        
    }
    }
    ?>