<?php
/**
 * procesa venta y actualiza saldo
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data=$_POST['arrayVenta'];
    $pago =$_POST['pago'];
    $new_array=json_decode($data,true);
    //print_r($data);

    $subtotal = 0;

    //$yummy->toppings[2]->id
    $idUsuario = $new_array[0]['idUsuario'];
    //echo "usuario ".$idUsuario." |";
    $idCliente = $new_array[0]['idCliente'];
    //echo "cliente ".$idCliente." |";
    $fecha = $new_array[0]['fecha'];
    //echo "fecha ".$fecha." |";
    //$total = $new_array[0]['total'];
    //echo "total ".$total." |";


    foreach($new_array as $row)
            {
                $subtotal = $subtotal + $row['total'];
            }
            //echo "subtotal : ".$subtotal;
    $procesar = Usuario::procesarVenta($idUsuario, $idCliente, $fecha, $subtotal);

    if ($procesar) {
        $idBoleta = Usuario::getUltimoIdBoleta($idUsuario);
        //echo 'id boleta ';
        //echo($idBoleta)."<br>";
       $procesarDetalle = Usuario::procesarDetalleVenta($idBoleta, $new_array);
       if ($procesarDetalle) {
        print json_encode(array('RESPUESTA' => 'COMPLETADO'));
        /*
           $saldo = Usuario::getSaldo($idUsuario, $idCliente);
           //$saldoAnterior = Usuario::getSaldoAnterior($idUsuario, $idCliente);
           $actualizarSaldo = Usuario::actualizarSaldo($idUsuario,$idCliente, $saldo, $pago, $subtotal);
           if ($actualizarSaldo) {
            print json_encode(array('RESPUESTA' => 'COMPLETADO'));
        }else{
            print json_encode(array('RESPUESTA' => 'ERROR SALDO'));
        }
        */
       }else{
        print json_encode(array('RESPUESTA' => 'ERROR DETALLE'));
       }       
        
    } else {
        print json_encode(array('RESPUESTA' => 'ERROR BOLETA'));
    }
    }
    ?>