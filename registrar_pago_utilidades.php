<?php
/**
 * procesa venta y actualiza saldo
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idUsuario =$_POST['idUsuario'];

    $fecha = $_POST['fecha'];

    $pago = $_POST['pagoTotal'];


           $reporte = Usuario::actualizarPago($idUsuario, $fecha, $pago);
           if ($reporte) {
            
            print json_encode(array('RESPUESTA' => 'COMPLETADO'));
        }else{
            print json_encode(array('RESPUESTA' => 'ERROR REPORTE'));
        }     

    }
    ?>