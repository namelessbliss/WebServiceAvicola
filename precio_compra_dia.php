<?php
/**
 * 
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idUsuario=$_POST['idUsuario'];

    $fecha=$_POST['fecha'];

    $compraDelDia = Usuario::precioCompraDia($idUsuario, $fecha);

    if ($compraDelDia ) {

        print json_encode($compraDelDia);

    } else {
        print json_encode(array('precioCompra' => 0));
    
    }
    }
    ?>