<?php
/**
 * procesa venta y actualiza saldo
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idBoleta =$_POST['idBoleta'];

    $idUsuario = $_POST['idUsuario'];

    $idCliente = $_POST['idCliente'];

           $Detalle = Usuario::getDetalleBoleta($idUsuario, $idCliente, $idBoleta);
          
           if ($Detalle) {
            print json_encode($Detalle);
        }else{
            print json_encode(array('RESPUESTA' => 'ERROR SALDO'));
        }     

    }
    ?>