<?php
/**
 * procesa venta y actualiza saldo
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idUsuario =$_POST['idUsuario'];

    $fecha = $_POST['fecha'];


           $reporte = Usuario::obtenerPesoVenta($idUsuario, $fecha);
           if ($reporte) {
            print json_encode($reporte);
        }else{
            print json_encode(array('RESPUESTA' => 'ERROR REPORTE'));
        }     

    }
    ?>