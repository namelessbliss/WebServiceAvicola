<?php
/**
 * procesa venta y actualiza saldo
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idUsuario =$_POST['idUsuario'];
    
    $pesoCompra =$_POST['pesoCompra'];

    $numJabas =$_POST['numJabas'];

    $valTara =$_POST['valTara'];

    $valDevolucion =$_POST['valDevolucion'];

    $capitalInversion =$_POST['capitalInversion'];

    $precioCompra = $_POST['precioCompra'];

    $fecha = $_POST['fecha'];


           $reporte = Usuario::registrarDatosReporte($idUsuario, $fecha, $pesoCompra, $numJabas, $valTara, $valDevolucion, $precioCompra, $capitalInversion);
           if ($reporte) {
            print json_encode(array('RESPUESTA' => 'COMPLETADO'));
        }else{
            print json_encode(array('RESPUESTA' => 'ERROR REPORTE'));
        }     

    }
    ?>