<?php
/**
 * procesa venta y actualiza saldo
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idUsuario =$_POST['idUsuario'];

    $fecha = $_POST['fecha'];

        $gananciaDia = Usuario::obtenerGananciaDiaNumero($idUsuario, $fecha);

        $capitalInversion = Usuario::obtenerCapitalInversion($idUsuario, $fecha);

        $gananciaFinal = $gananciaDia - $capitalInversion;


           $reporte = Usuario::obtenerPago($idUsuario, $fecha);
           if ($reporte) {
            $pago = $reporte['pago'];

            $arrayReporte = array('ganancia' => $gananciaFinal,'pago' =>$pago);
            
            print json_encode($arrayReporte);
        }else{
            print json_encode(array('RESPUESTA' => 'ERROR REPORTE'));
        }     

    }
    ?>