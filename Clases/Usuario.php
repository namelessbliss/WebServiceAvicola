<?php

/**
 * Lista de funciones consulta para la bd
 */
require 'DB/Database.php';

class Usuario
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'Usuario'
     *
     * @param $idAlumno Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll(){
        $consulta = "SELECT * FROM usuario";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $error) {
            echo 'Ocurrio un error con la conexion <br>';
            echo $error->getMessage();
            return false;
        }
    }

    public static function getUsuario($username, $password){
        $consulta = "SELECT NOMBRE FROM usuario WHERE USERNAME = ? AND PASSWORD = ?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($username,$password));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            echo 'Ocurrio un error con la conexion <br>';
            echo $e->getMessage();
            return false;
        }
    }
    
    public static function usuarioExiste($username, $password){
        $consulta = "SELECT COUNT(*) as total_rows FROM usuario WHERE USERNAME = ? AND PASSWORD = ?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($username,$password));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            $total_rows = $row['total_rows'];
            if($total_rows < 1){
                //echo 'retorna false';
                return false;
            }else {
                //echo 'retorna row';
            return $row;    
            }

        } catch (PDOException $e) {
            echo 'Ocurrio un error con la conexion <br>';
            echo $e->getMessage();
            return false;
        }
    }
        public static function getIdUsuario($username, $password){
        $consulta = "SELECT ID_USUARIO FROM usuario WHERE USERNAME = ? AND PASSWORD = ?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($username,$password));
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row["ID_USUARIO"];

        } catch (PDOException $e) {
            echo 'Ocurrio un error con la conexion <br>';
            echo $e->getMessage();
            return false;
        }
    } 

    public static function procesarVenta($idUsuario,$idCliente,$fecha,$total){
        $consulta = "INSERT INTO boleta (ID_USUARIO, ID_CLIENTE, FECHA, total) VALUES(?, ?, ?, ?)";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idUsuario, $idCliente, $fecha, $total));

            return $comando;

        } catch (PDOException $error) {
            echo 'Ocurrio un error al procesar venta <br>';
            echo $error->getMessage();
            return false;
        }
    }

    public static function getUltimoIdBoleta($idUsuario){
        $consulta = "SELECT ID_BOLETA FROM boleta WHERE ID_USUARIO = ? ORDER BY ID_BOLETA DESC LIMIT 1";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idUsuario));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row["ID_BOLETA"];

        } catch (PDOException $e) {
            echo 'Ocurrio un error obteniendo idboleta <br>';
            echo $e->getMessage();
            return false;
        }
    }

    public static function procesarDetalleVenta($idBoleta, $array){
        $consulta = "INSERT INTO detalle_boleta (ID_BOLETA, ID_PRODUCTO, ID_CLIENTE, PRECIO, CANTIDAD, PESO) VALUES(?, ?, ?, ?, ?, ?)";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            foreach($array as $row)
            {
            $comando->execute(array($idBoleta,  $row['idProducto'], $row['idCliente'], $row['precio'], $row['cantidad'], $row['pesoNeto']));
            }
            
            return $comando;

        } catch (PDOException $error) {
            echo 'Ocurrio un error al procesar detalle venta <br>';
            echo $error->getMessage();
            return false;
        }
    }

    public static function boletaPagada($idBoleta, $idUsuario, $idCliente){
        $consulta = "UPDATE `boleta` SET `boletaPagada` = '1' WHERE `boleta`.`ID_BOLETA` = ? AND `boleta`.`ID_USUARIO` = ? AND `boleta`.`ID_CLIENTE` = ?;";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idBoleta, $idUsuario, $idCliente));

            return $comando;

            } catch (PDOException $error) {
                echo 'Ocurrio un error al actualizar saldo <br>';
                echo $error->getMessage();
                return false;
            }
    }

    public static function actualizarSaldo($idUsuario, $idCliente, $saldo_anterior, $saldo_actual, $fecha, $pago){
        $consulta = "UPDATE `saldo` SET `saldo_anterior` = ?, `saldo` = ? , `pago` = ? , `fecha` = ? WHERE `saldo`.`id_usuario` = ? AND `saldo`.`ID_CLIENTE` = ?;";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($saldo_anterior, $saldo_actual, $pago, $fecha, $idUsuario, $idCliente));

            return $comando;

            } catch (PDOException $error) {
                echo 'Ocurrio un error al actualizar saldo <br>';
                echo $error->getMessage();
                return false;
            }
    }

    public static function getSaldo($idUsuario, $idCliente){
        $valor = 0;
        $consulta = "SELECT saldo FROM saldo WHERE `saldo`.`id_usuario` = ? AND `saldo`.`ID_CLIENTE` = ?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idUsuario, $idCliente));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);

            if (isset($row["saldo"])) {
                return $row["saldo"];
            }else{
                return $valor;
            }

        } catch (PDOException $e) {
            echo 'Ocurrio un error obteniendo saldo <br>';
            echo $e->getMessage();
            return false;
        }
    }

    public static function getSaldoAnterior($idUsuario, $idCliente){
        $consulta = "SELECT saldo_anterior FROM saldo WHERE `saldo`.`id_usuario` = ? AND `saldo`.`ID_CLIENTE` = ?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idUsuario, $idCliente));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row["saldo_anterior"];

        } catch (PDOException $e) {
            echo 'Ocurrio un error obteniendo saldo <br>';
            echo $e->getMessage();
            return false;
        }
    }

    public static function getBoletas($idUsuario, $idCliente){
            $consulta = "SELECT * FROM `boleta` WHERE ID_USUARIO = ? AND ID_CLIENTE = ? ORDER BY ID_BOLETA DESC";
            try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario, $idCliente));

                return $comando->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $error) {
                echo 'Ocurrio un error con la conexion <br>';
                echo $error->getMessage();
                return false;
            }
        }

        public static function getSaldoCliente($idUsuario, $idCliente){
            $consulta = "SELECT saldo_anterior, saldo FROM `saldo` WHERE id_usuario = ? AND ID_CLIENTE = ?";
            try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario, $idCliente));

                return $comando->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $error) {
                echo 'Ocurrio un error con la conexion <br>';
                echo $error->getMessage();
                return false;
            }
        }

        /*

        public static function eliminarDetalleCliente($idCliente){
            $consulta = "DELETE FROM `detalle_boleta` WHERE ID_CLIENTE = ?";
            try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idCliente));

                return $comando->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $error) {
                echo 'Ocurrio un error con la conexion <br>';
                echo $error->getMessage();
                return false;
            }
        }

        public static function eliminarBoletaCliente($idUsuario, $idCliente){
            $consulta = "DELETE FROM `boleta` WHERE ID_USUARIO = ? AND ID_CLIENTE = ?";
            try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario, $idCliente));

                return $comando->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $error) {
                echo 'Ocurrio un error con la conexion <br>';
                echo $error->getMessage();
                return false;
            }
        }

        public static function eliminarSaldo($idUsuario, $idCliente){
            $consulta = "DELETE FROM `saldo` WHERE id_usuario = ? AND ID_CLIENTE = ?";
            try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario, $idCliente));

                return $comando->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $error) {
                echo 'Ocurrio un error con la conexion <br>';
                echo $error->getMessage();
                return false;
            }
        }
        */

        public static function eliminarCliente($idUsuario, $idCliente){
            $estado = 0;
            $consulta = "UPDATE `cliente` SET `ESTADO`= ? WHERE ID_USUARIO = ? AND ID_CLIENTE = ?";
            try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($estado, $idUsuario, $idCliente));

                return $comando;

            } catch (PDOException $error) {
                echo 'Ocurrio un error con la conexion <br>';
                echo $error->getMessage();
                return false;
            }
        }

        public static function registrarCliente($idUsuario, $nombreCliente, $estadoCliente){
        $consulta = "INSERT INTO cliente (ID_USUARIO, NOMBRE_CLIENTE, ESTADO) VALUES(?, ?, ?)";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idUsuario, $nombreCliente, $estadoCliente));
            
            return $comando;

        } catch (PDOException $error) {
            echo 'Ocurrio un error al procesar detalle venta <br>';
            echo $error->getMessage();
            return false;
        }
    }

    public static function getUltimoIdCliente($idUsuario){
        $consulta = "SELECT ID_CLIENTE FROM cliente WHERE ID_USUARIO = ? ORDER BY ID_CLIENTE DESC LIMIT 1";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idUsuario));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row["ID_CLIENTE"];

        } catch (PDOException $e) {
            echo 'Ocurrio un error obteniendo idboleta <br>';
            echo $e->getMessage();
            return false;
        }
    }

    public static function registrarSaldo($idUsuario, $idCliente, $saldo){
        $saldoAnterior = 0;
        $decimal = (float) $saldo;
        echo $saldo."<br>";
        $consulta = "INSERT INTO saldo (id_usuario, ID_CLIENTE, saldo_anterior, saldo) VALUES(?, ?, ?,".$decimal.")";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idUsuario, $idCliente, $saldoAnterior));
            
            return $comando;

        } catch (PDOException $error) {
            echo 'Ocurrio un error al procesar detalle venta <br>';
            echo $error->getMessage();
            return false;
        }
    }

    public static function getDetalleBoleta($idUsuario, $idCliente, $idBoleta){
            $consulta = "SELECT * FROM `venta` WHERE ID_USUARIO = ? AND ID_CLIENTE = ? AND ID_BOLETA = ?";
            try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario, $idCliente, $idBoleta));

                return $comando->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $error) {
                echo 'Ocurrio un error con la conexion <br>';
                echo $error->getMessage();
                return false;
            }
        }

        public static function actualizarVenta($idUsuario,$idCliente,$idBoleta,$total){
        $consulta = "UPDATE `boleta` SET total = ? WHERE ID_BOLETA = ? AND ID_USUARIO = ? AND ID_CLIENTE = ?";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($total, $idBoleta, $idUsuario, $idCliente));
            // retorna comando
            return $comando;

        } catch (PDOException $error) {
            echo 'Ocurrio un error al actualizar venta <br>';
            echo $error->getMessage();
            return false;
        }
    }

    public static function actualizarDetalleVenta($idBoleta, $idCliente, $array){
        $consulta = "UPDATE `venta` SET `PRECIO`= ? WHERE `ID_BOLETA` = ? AND `ID_CLIENTE` = ? AND `NOMBRE_PRODUCTO` = ?;";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            foreach($array as $row)
            {
                $precio = $row['precio'];
                $producto = $row['producto'];
            $comando->execute(array($precio, $idBoleta, $idCliente, $producto));
            }
            
            return $comando;

        } catch (PDOException $error) {
            echo 'Ocurrio un error al procesar detalle venta <br>';
            echo $error->getMessage();
            return false;
        }
    }

    public static function estadoCuenta($idUsuario){
        $valor = 0;
        $consulta = "SELECT NOMBRE_CLIENTE,pago,saldo,fecha FROM `saldoPago` WHERE id_usuario = ? AND ESTADO = 1";
        try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario));

                return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo 'Ocurrio un error obteniendo saldo <br>';
            echo $e->getMessage();
            return false;
        }
    }

    public static function registrarDatosReporte($idUsuario, $fecha, $pesoCompra, $numJabas, $valTara, $valDevolucion, $precioCompra, $capitalInversion){
        $consulta = "INSERT INTO utilidades (ID_USUARIO, fecha, peso_compra, precio_compra, numero_jaba, valor_tara, valor_devolucion, capital_inversion) VALUES(?, ?, ?, ?, ?, ?, ?,?)";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idUsuario, $fecha, $pesoCompra, $precioCompra, $numJabas, $valTara, $valDevolucion, $capitalInversion));
            
            return $comando;

        } catch (PDOException $error) {
            echo 'Ocurrio un error al procesar detalle reporte <br>';
            echo $error->getMessage();
            return false;
        }
    }

    public static function obtenerReporteExistente($idUsuario, $fecha){
    
        $consulta = "SELECT peso_compra, precio_compra, numero_jaba, valor_tara, valor_devolucion, capital_inversion FROM `utilidades` WHERE ID_USUARIO = ? AND fecha = ?";
        try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario, $fecha));

                return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo 'Ocurrio un error obteniendo saldo <br>';
            echo $e->getMessage();
            return false;
        }
    }

    public static function obtenerPesoVenta($idUsuario, $fecha){
        $text = $fecha."%";
        $consulta = "SELECT sum(peso) FROM `venta` WHERE ID_USUARIO = ? AND FECHA LIKE "."'".$text."'";
        try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario));

                return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo 'Ocurrio un error obteniendo saldo <br>';
            echo $e->getMessage();
            return false;
        }
    }

    public static function obtenerGananciaDia($idUsuario, $fecha){
        $text = $fecha."%";
        $consulta = "SELECT SUM(peso*precio) FROM `venta` WHERE ID_USUARIO = ? AND FECHA LIKE "."'".$text."'";
        try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario));

                return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo 'Ocurrio un error obteniendo saldo <br>';
            echo $e->getMessage();
            return false;
        }
    }

    public static function obtenerGananciaDiaNumero($idUsuario, $fecha){
        $text = $fecha."%";
        $consulta = "SELECT SUM(peso*precio) FROM `venta` WHERE ID_USUARIO = ? AND FECHA LIKE "."'".$text."'";
        try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario));
                // Capturar primera fila del resultado
                $row = $comando->fetch(PDO::FETCH_ASSOC);
                return $row["SUM(peso*precio)"];

        } catch (PDOException $e) {
            echo 'Ocurrio un error obteniendo saldo <br>';
            echo $e->getMessage();
            return false;
        }
    }

    public static function obtenerCapitalInversion($idUsuario, $fecha){
    
        $consulta = "SELECT peso_compra, precio_compra,capital_inversion FROM `utilidades` WHERE ID_USUARIO = ? AND fecha = ?";
        try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario, $fecha));

                $row = $comando->fetch(PDO::FETCH_ASSOC);
                return $row["capital_inversion"];

        } catch (PDOException $e) {
            echo 'Ocurrio un error obteniendo saldo <br>';
            echo $e->getMessage();
            return false;
        }
    }

    public static function obtenerPago($idUsuario, $fecha){
    
        $consulta = "SELECT pago FROM `utilidades` WHERE ID_USUARIO = ? AND fecha = ?";
        try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario, $fecha));

                return $comando->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo 'Ocurrio un error obteniendo saldo <br>';
            echo $e->getMessage();
            return false;
        }
    }

    public static function actualizarPago($idUsuario, $fecha, $pago){
        $consulta = "UPDATE `utilidades` SET `pago`= ? WHERE `ID_USUARIO` = ? AND `fecha` = ? ;";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($pago, $idUsuario, $fecha));
            
            return $comando;

        } catch (PDOException $error) {
            echo 'Ocurrio un error al procesar detalle venta <br>';
            echo $error->getMessage();
            return false;
        }
    }

    public static function cuadroUtilidades($idUsuario, $fecha){
        $text = $fecha."%";
        $consulta = "SELECT NOMBRE_CLIENTE as `cliente`, SUM(PRECIO*PESO) as `ventaDia`, SUM(peso) as `peso`, SUM(cantidad) as `cantidad` FROM `venta` WHERE ID_USUARIO = ? AND FECHA LIKE ? GROUP BY NOMBRE_CLIENTE";
        try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario, $text));

                return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo 'Ocurrio un error obteniendo saldo <br>';
            echo $e->getMessage();
            return false;
        }
    }
    //deprecado
    public static function sumaVentaDia($idUsuario, $fecha){
        $text = $fecha."%";
        $consulta = "SELECT SUM(PRECIO*PESO) as `ventaDia` FROM `venta` WHERE ID_USUARIO = ? AND FECHA LIKE ? ";
        try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario, $text));

                 $row = $comando->fetch(PDO::FETCH_ASSOC);

                 return $row["ventaDia"];

        } catch (PDOException $e) {
            echo 'Ocurrio un error obteniendo saldo <br>';
            echo $e->getMessage();
            return false;
        }
    }
    //deprecado
    public static function inversionDelDia($idUsuario, $fecha){
        $text = $fecha."%";
        $consulta = "SELECT capital_inversion as `compraDia` FROM `utilidades` WHERE ID_USUARIO = ? AND FECHA LIKE ? ";
        try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario, $text));
				
                $row = $comando->fetch(PDO::FETCH_ASSOC);

                return $row["compraDia"];  

        } catch (PDOException $e) {
            echo 'Ocurrio un error obteniendo saldo <br>';
            echo $e->getMessage();
            return false;
        }
    }

    public static function precioCompraDia($idUsuario, $fecha){
        $text = $fecha."%";
        $consulta = "SELECT precio_compra as `precioCompra` FROM `utilidades` WHERE ID_USUARIO = ? AND FECHA LIKE ? ";
        try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idUsuario, $text));
                
                return $comando->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo 'Ocurrio un error obteniendo saldo <br>';
            echo $e->getMessage();
            return false;
        }
    }

    public static function eliminarDetalleVenta($idCliente, $idBoleta){
            $estado = 0;
            $consulta = "DELETE FROM `detalle_boleta` WHERE `detalle_boleta`.`ID_BOLETA` = ? AND  `detalle_boleta`.`ID_CLIENTE` = ?";
            try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idBoleta, $idCliente));

                return $comando;

            } catch (PDOException $error) {
                echo 'Ocurrio un error con la conexion <br>';
                echo $error->getMessage();
                return false;
            }
        }

    public static function eliminarVenta($idUsuario, $idCliente, $idBoleta){
            $estado = 0;
            $consulta = "DELETE FROM `boleta` WHERE `boleta`.`ID_BOLETA` = ? AND `boleta`.`ID_USUARIO` = ? AND `boleta`.`ID_CLIENTE` = ?";
            try {
                // Preparar sentencia
                $comando = Database::getInstance()->getDb()->prepare($consulta);
                // Ejecutar sentencia preparada
                $comando->execute(array($idBoleta, $idUsuario, $idCliente));

                return $comando;

            } catch (PDOException $error) {
                echo 'Ocurrio un error con la conexion <br>';
                echo $error->getMessage();
                return false;
            }
        }

}