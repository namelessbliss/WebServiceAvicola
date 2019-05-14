<?php
/**
 * Obtiene el detalle de un usuario especificado por
 * su usuario y contrase�a
 */

require 'Clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') { //Si el http request es de metodo GET

    if (isset($_GET['username']) && isset($_GET['password'])) { // Si estan establecidos los campos 

        // Obtener par�metros
          $username = $_GET['username'];
          $password = $_GET['password'];

        // Llamo a la funcions getUsuario, devuelve un String nombre, de lo contrario un false
        $retorno = Usuario::getUsuario($username, $password);


        if ($retorno) {

            //$usuario["estado"] = 1;		
            //$usuario["usuario"] = $retorno;
            // Enviar objeto json del usuario
            
            //Transforma e imprime en JSON el o los atributos del objeto retornado
            print json_encode($retorno);
        } else {
            // Enviar respuesta de error general
            print json_encode(
                array(
                    'mensaje' => 'usuario o contrase�a invalidos'
                )
            );
        }
    } else {
        // Enviar respuesta de error
        print json_encode(
            array(
                'mensaje' => 'Es necesario llenar el usuario y la contrase�a'
            )
        );
    }
}else{
   // Enviar respuesta de error
        print json_encode(
            array(
                'mensaje' => 'No valido'
            )
        ); 
}

