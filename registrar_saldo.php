<?php
/**
 * procesa venta y actualiza saldo
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $saldoAnterior =$_POST['saldoAnterior'];
    
    $saldoActual =$_POST['saldoActual'];

    $idBoleta = $_POST['idBoleta'];

    $idUsuario = $_POST['idUsuario'];

    $idCliente = $_POST['idCliente'];

    $fecha = $_POST['fecha'];

    $pago = $_POST['pago'];

            $pagoBoleta = Usuario::boletaPagada($idBoleta, $idUsuario, $idCliente);

        if ($pagoBoleta) {

            $actualizarSaldo = Usuario::actualizarSaldo($idUsuario, $idCliente, $saldoAnterior, $saldoActual, $fecha, $pago);

           if ($actualizarSaldo) {

            print json_encode(array('RESPUESTA' => 'COMPLETADO'));
            
            }else{
                print json_encode(array('RESPUESTA' => 'ERROR SALDO'));
            }

        }else{
            print json_encode(array('RESPUESTA' => 'ERROR PAGO BOLETA'));
        }

                

    }
    ?>