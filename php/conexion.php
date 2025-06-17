<?php

class Conexion
{
    #Atributos
    private $host; // localhost o IP
    private $db;   // Nombre de la base de datos
    private $usuario; // Usuario de la base de datos
    private $pass;    // Contraseña
    private $charset; // Codificación de caracteres

    #Constructor
    public function __construct()
    {
        $this->host = 'localhost'; // Cambiar si es necesario
        $this->db = 'users';       // Nombre correcto de tu base de datos
        $this->usuario = 'root';   // Usuario de tu base de datos
        $this->pass = '';          // Contraseña (vacía por defecto)
        $this->charset = 'utf8';   // Charset recomendado
    }

    #Método para conectar
    public function conectar()
    {
        try {
            # Configuración de PDO
            $com = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $enlace = new PDO($com, $this->usuario, $this->pass);

            # Configurar excepciones para errores de conexión
            $enlace->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $enlace->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            # Retornar la conexión
            return $enlace;
        } catch (PDOException $e) {
            # Mostrar un error claro si no se puede conectar
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }
}

?>
