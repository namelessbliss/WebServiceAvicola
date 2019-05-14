<?php
/**
 * procesa venta y actualiza saldo
 */
require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idUsuario =$_POST['idUsuario'];
    $nombreCliente =$_POST['nombreCliente'];
    $saldo =$_POST['saldoCliente'];
    $estadoCliente =$_POST['estadoCliente'];

    /*
    echo $saldo."<br>";
    echo $saldo+0.0."<br>";
	*/
    
    $registrar = Usuario::registrarCliente($idUsuario, $nombreCliente, $estadoCliente);

    if ($registrar) {

    	$idCliente = Usuario::getUltimoIdCliente($idUsuario);
    	$saldo = $saldo + 0.0;
    	$registrarSaldoCliente = Usuario::registrarSaldo($idUsuario, $idCliente, $saldo);

    	if ($registrarSaldoCliente) {

    		print json_encode(array('RESPUESTA' => 'COMPLETADO'));

    	} else {
			print json_encode(array('RESPUESTA' => 'ERROR CREAR SALDO'));    		
    	}
        
    } else {
        print json_encode(array('RESPUESTA' => 'ERROR REGISTRAR CLIENTE'));
    }
    
    }
    ?>