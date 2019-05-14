<?php
/**
 * Obtiene todas las alumnos de la base de datos
 */

require 'Clases/Cliente.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['idUsuario'])) {
        // Manejar petición POST
            $idUsuario = $_POST['idUsuario'];
        // Llamo a la funcions , devuelve un 
            $clientes = Cliente::getNombresClientes($idUsuario);
        if ($clientes) {

            print json_encode($clientes);
        } else {
            // Enviar respuesta de error general
                print json_encode(
                    array(
                        'RESPUESTA' => 'No hay clientes'
                    )
                );
        }
    }
}

