<?php
/**
 * Da de respuesta si el usuario existe o no en la bd
 * acorde a los parametros usuario y contraseña
 */

require 'Clases/Usuario.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') { //Si el http request es de metodo GET

    if (isset($_GET['username']) && isset($_GET['password'])) { // Si estan establecidos los campos 

        // Obtener parámetros
          $username = $_GET['username'];
          $password = $_GET['password'];

        // Llamo a la funcions getUsuario, devuelve un String nombre, de lo contrario un false
        $retorno = Usuario::usuarioExiste($username, $password);

        if ($retorno) {

            //$usuario["estado"] = 1;		
            //$usuario["usuario"] = $retorno;
            // Enviar objeto json del usuario
            $idUsuario = Usuario::getIdUsuario($username, $password);
            //Transforma e imprime en JSON el o los atributos del objeto retornado
            print json_encode(array('RESPUESTA'=> "si","IDUSUARIO" => $idUsuario));
        } else {
        	// Enviar respuesta de usuario inexistente
            print json_encode(array('RESPUESTA'=> "Usuario o contraseña invalido"), JSON_UNESCAPED_UNICODE);
       }
    } else {
        // Enviar respuesta de error
        print json_encode(array('RESPUESTA'=> "Es necesario llenar el usuario y la contraseña"));
    }
}else{
   // Enviar respuesta de error
   print json_encode(array('RESPUESTA'=> "No valido"));

}
?>