<?php

require 'DB/Database.php';

class Cliente
{
    function __construct()
    {
    }

    public static function getNombresClientes($idUsuario){
            $consulta = "SELECT ID_CLIENTE, NOMBRE_CLIENTE FROM `cliente` WHERE ID_USUARIO = ? AND estado = 1";
            try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario));

                return $comando->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $error) {
                echo 'Ocurrio un error con la conexion <br>';
                echo $error->getMessage();
                return false;
            }
        }
    }