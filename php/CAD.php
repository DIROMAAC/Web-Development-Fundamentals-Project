<?php

require_once "conexion.php";

class CAD
{
    public $con;

    static public function agregaUsuario($nombre, $contrasena, $correo)
    {
        try {
            $con = new Conexion();
            $query = $con->conectar()->prepare("INSERT INTO usuario (nombre, correo, contrasena) VALUES (:nombre, :correo, :contrasena)");
            $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $query->bindParam(':correo', $correo, PDO::PARAM_STR);
            $query->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
            
            if ($query->execute()) {
                return "Usuario agregado correctamente.";
            } else {
                return "Error al agregar el usuario.";
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    static public function verificaUsuario($correo, $contrasena)
    {
        try {
            $con = new Conexion();
            $query = $con->conectar()->prepare("SELECT idUsuario, nombre, correo, Rol FROM usuario WHERE correo = :correo AND contrasena = :contrasena");
            $query->bindParam(':correo', $correo, PDO::PARAM_STR);
            $query->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
            $query->execute();
    
            if ($query->rowCount() > 0) {
                // Usuario encontrado
                return $query->fetch(PDO::FETCH_ASSOC);
            } else {
                // Usuario no encontrado
                return false;
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
    

    static public function modificaUsuario($datosModificar, $idUsuario)
    {
        try {
            $con = new Conexion();
            $queryStr = "UPDATE usuario SET ";
            $params = [];
            foreach ($datosModificar as $campo => $valor) {
                $queryStr .= "$campo = :$campo, ";
                $params[":$campo"] = $valor;
            }
            $queryStr = rtrim($queryStr, ', ') . " WHERE idUsuario = :idUsuario";
            $params[":idUsuario"] = $idUsuario;
    
            $query = $con->conectar()->prepare($queryStr);
            if ($query->execute($params)) {
                return "Usuario modificado correctamente.";
            } else {
                return "Error al modificar el usuario.";
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
    

    static public function traeUsuarios()
    {
        $con = new Conexion();
        $query = $con->conectar()->prepare("SELECT * FROM usuario ORDER BY idUsuario ASC");
        if($query->execute())
        {
            $datos = [];
            //mas de un registro
            while ($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $datos[] = $row;

            }
            #print_r($datos);
            return $datos;    
        }
        else
        {
            return false;
        }
    }

    static public function eliminaUsuario($idUsuario)
    {
        $con = new Conexion();//establecer conexion a bd
        $query = $con->conectar()->prepare("DELETE FROM usuario WHERE idUsuario = $idUsuario");
        if($query->execute())
        {
           return 1;
        }
        else
        {
            echo "Hubo un error";
            print_r($con->conectar()->errorInfo()); 
            return 0;
        }
    }

    public static function agregaConcierto($fecha, $hora, $artista, $lugar, $precio)
    {
        $con = new Conexion(); // Establecer conexión a la base de datos
        $query = $con->conectar()->prepare("INSERT INTO conciertos (fecha, hora, artista, lugar, precio) VALUES (:fecha, :hora, :artista, :lugar, :precio)");
        $query->bindParam(':fecha', $fecha);
        $query->bindParam(':hora', $hora);
        $query->bindParam(':artista', $artista);
        $query->bindParam(':lugar', $lugar);
        $query->bindParam(':precio', $precio);
        
        if ($query->execute()) {
            return 1;
        } else {
            echo "Hubo un error";
            print_r($query->errorInfo());
            return 0;
        }
    }
    
    public static function traeConciertos()
    {
        $con = new Conexion(); // Establecer conexión a la base de datos
        $query = $con->conectar()->prepare("SELECT idConcierto, fecha, hora, artista, lugar, precio FROM conciertos ORDER BY fecha ASC");
        
        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "Error al obtener los conciertos.";
            return [];
        }
    }
    
    public function eliminaConcierto($idConcierto)
    {
        $con = (new Conexion())->conectar(); // Establecer conexión a la base de datos
        $query = $con->prepare("DELETE FROM conciertos WHERE idConcierto = :idConcierto");
        $query->bindParam(':idConcierto', $idConcierto, PDO::PARAM_INT);
        
        return $query->execute();
    }
    
    public function modificaConcierto($datosModificar, $idConcierto)
    {
        $con = new Conexion(); // Establecer conexión a la base de datos
        $query = $con->conectar()->prepare("UPDATE conciertos SET $datosModificar WHERE idConcierto = :idConcierto");
        $query->bindParam(':idConcierto', $idConcierto, PDO::PARAM_INT);
        
        if ($query->execute()) {
            return true;
        } else {
            print_r($query->errorInfo());
            return false;
        }
    }
    
    public function traeConciertoPorId($idConcierto)
    {
        $con = (new Conexion())->conectar(); // Establecer conexión a la base de datos
        $query = $con->prepare("SELECT * FROM conciertos WHERE idConcierto = ?");
        $query->execute([$idConcierto]);
        
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function agregaCodigoDescuento($codigo, $descuento)
    {
        try {
            $con = new Conexion();
            $query = $con->conectar()->prepare("INSERT INTO codigos_descuento (codigo, descuento) VALUES (:codigo, :descuento)");
            $query->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $query->bindParam(':descuento', $descuento, PDO::PARAM_INT);
            
            if ($query->execute()) {
                return "Código de descuento agregado correctamente.";
            } else {
                return "Error al agregar el código de descuento.";
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /**
     * Traer todos los códigos de descuento
     */
    public static function traeCodigosDescuento()
    {
        try {
            $con = new Conexion();
            $query = $con->conectar()->prepare("SELECT * FROM codigos_descuento ORDER BY idCodigo ASC");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /**
     * Eliminar un código de descuento
     */
    public static function eliminaCodigoDescuento($idCodigo)
    {
        try {
            $con = new Conexion();
            $query = $con->conectar()->prepare("DELETE FROM codigos_descuento WHERE idCodigo = :idCodigo");
            $query->bindParam(':idCodigo', $idCodigo, PDO::PARAM_INT);
            if ($query->execute()) {
                return "Código de descuento eliminado correctamente.";
            } else {
                return "Error al eliminar el código de descuento.";
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function agregaArtista($nombre, $biografia, $foto)
    {
        try {
            $con = new Conexion();
            $query = $con->conectar()->prepare("INSERT INTO artistas (nombre, biografia, imagen) VALUES (:nombre, :biografia, :imagen)");
            $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $query->bindParam(':biografia', $biografia, PDO::PARAM_STR);
            $query->bindParam(':imagen', $foto, PDO::PARAM_STR);
            
            if ($query->execute()) {
                return true;  // Artista agregado correctamente
            } else {
                return "Error al agregar el artista.";
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function eliminaArtista($idArtista)
    {
        try {
            $con = new Conexion(); // Establecer conexión a la base de datos
    
            // Obtener el nombre de la imagen del artista para eliminarla del servidor
            $query = $con->conectar()->prepare("SELECT imagen FROM artistas WHERE idArtista = :idArtista");
            $query->bindParam(':idArtista', $idArtista, PDO::PARAM_INT);
            $query->execute();
            $artista = $query->fetch(PDO::FETCH_ASSOC);
    
            if ($artista && $artista['imagen']) {
                // Eliminar la imagen del directorio
                $imagePath = "../imgart/" . basename($artista['imagen']);
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Eliminar la imagen
                }
            }
    
            // Ahora eliminar el artista de la base de datos
            $query = $con->conectar()->prepare("DELETE FROM artistas WHERE idArtista = :idArtista");
            $query->bindParam(':idArtista', $idArtista, PDO::PARAM_INT);
            if ($query->execute()) {
                return "Artista eliminado correctamente.";
            } else {
                return "Error al eliminar el artista.";
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public static function modificaArtista($datosModificar, $idArtista)
    {
        try {
            $con = new Conexion();
            $queryStr = "UPDATE artistas SET ";
            $params = [];
            foreach ($datosModificar as $campo => $valor) {
                $queryStr .= "$campo = :$campo, ";
                $params[":$campo"] = $valor;
            }
            $queryStr = rtrim($queryStr, ', ') . " WHERE idArtista = :idArtista";
            $params[":idArtista"] = $idArtista;
    
            $query = $con->conectar()->prepare($queryStr);
            if ($query->execute($params)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function traeArtistaPorId($idArtista) {
        try {
            // Establecer la conexión
            $con = new Conexion();
            // Preparar la consulta
            $query = $con->conectar()->prepare("SELECT * FROM artistas WHERE idArtista = ?");
            // Ejecutar la consulta
            $query->execute([$idArtista]);
    
            // Si se encuentra el artista, retornar el primer resultado
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
    
    // Método para agregar una canción
    public function agregarCancion($idartista, $titulo, $archivo_audio) {
        try {
            $con = new Conexion();  // Inicializas la conexión dentro del método
            $query = $con->conectar()->prepare("INSERT INTO canciones (idartista, titulo, archivo_audio) VALUES (?, ?, ?)");
            $query->execute([$idartista, $titulo, $archivo_audio]);
            return $query->rowCount() > 0; // Retorna verdadero si se insertó correctamente
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Método para obtener las canciones por artista
    public function obtenerCancionesPorArtista($idartista) {
        try {
            $con = new Conexion();  // Inicializas la conexión dentro del método
            $query = $con->conectar()->prepare("SELECT * FROM canciones WHERE idartista = ?");
            $query->execute([$idartista]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Método para obtener una canción por su ID
    public function traerCancionPorId($idCancion) {
        try {
            $con = new Conexion();  // Crear una instancia de la clase Conexion
            $query = $con->conectar()->prepare("SELECT * FROM canciones WHERE idCancion = ?");
            $query->execute([$idCancion]);
        
            // Verifica si la canción fue encontrada
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                echo "Canción no encontrada. ID recibido: " . htmlspecialchars($idCancion);
            }
            return $result;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Método para eliminar una canción
    public function eliminarCancion($idCancion) {
        try {
            $con = new Conexion();  // Crear una instancia de la clase Conexion
            $query = $con->conectar()->prepare("DELETE FROM canciones WHERE idCancion = ?");
            $query->execute([$idCancion]);

            // Retorna verdadero si se eliminó correctamente, falso si no se eliminó
            return $query->rowCount() > 0;  
        } catch (Exception $e) {
            // Manejo de excepciones
            return false;  // Retorna false en caso de error
        }
    }

    
}

?>