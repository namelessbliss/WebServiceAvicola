<?php
/**
 * obtiene las boletas del cliente del usuario
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idUsuario=$_POST['idUsuario'];

    $fecha=$_POST['fecha'];

    $ventaDelDia = Usuario::sumaVentaDia($idUsuario, $fecha);

    if ($ventaDelDia ) {

        $compraDelDia = Usuario::inversionDelDia($idUsuario, $fecha);

        if ($compraDelDia ) {


        $utilidadDia = ($ventaDelDia - $compraDelDia);

        print json_encode(array('utilidadDia' => $utilidadDia, 'ventaDia' => $ventaDelDia, 'compraDia' => $compraDelDia));

        } else {
            $utilidadDia = ($ventaDelDia - 0);

        print json_encode(array('utilidadDia' => $utilidadDia, 'ventaDia' => $ventaDelDia, 'compraDia' => 0));
        }

    } else {

        $compraDelDia = Usuario::inversionDelDia($idUsuario, $fecha);

        if ($compraDelDia ) {

        $utilidadDia = (0 - $compraDelDia);

        print json_encode(array('utilidadDia' => $utilidadDia, 'ventaDia' => 0, 'compraDia' => $compraDelDia));

        } else {

            $utilidadDia = 0;

            print json_encode(array('utilidadDia' => $utilidadDia, 'ventaDia' => 0, 'compraDia' => 0));
        }
    
    }
    }
    ?>