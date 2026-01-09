<?php

class DatabaseService
{
    private ?PDO $pdo = null;

    /**
     * Intenta establecer una conexión con la base de datos usando variables de entorno.
     * @throws Exception Si faltan variables de entorno o falla la conexión.
     */
    public function __construct()
    {
        $db_host = 'db'; 
        // Uso getenv() para acceder a las variables de entorno inyectadas por Docker Compose
        $db_name = getenv('MYSQL_DATABASE');
        $db_user = getenv('MYSQL_USER');
        $db_pass = getenv('MYSQL_PASSWORD');
        
        if (!$db_name || !$db_user || !$db_pass) {
            throw new Exception("ERROR: Las variables de entorno de la base de datos (MYSQL_DATABASE, MYSQL_USER, MYSQL_PASSWORD) no están configuradas.");
        }

        try {
            // Opciones de PDO para rendimiento y estabilidad
            $options = [
                // Asegura que los errores de SQL se manejen como excepciones PHP (ESTABILIDAD)
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                // Define el modo de fetch por defecto (CONSISTENCIA)
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // Define un timeout para fallos rápidos en la conexión (RENDIMIENTO)
                PDO::ATTR_TIMEOUT => 5, 
            ];

            $this->pdo = new PDO(
                "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", 
                $db_user, 
                $db_pass,
                $options
            );
        } catch (PDOException $e) {
            // Lanza una excepción controlada, ocultando la complejidad interna de PDO
            throw new Exception("ERROR: Fallo al conectar con la base de datos '{$db_host}'. Mensaje: " . $e->getMessage());
        }
    }

    /**
     * Retorna el estado de la conexión.
     */
    public function getStatus(): string
    {
        if ($this->pdo) {
            return "<p>✅ Conexión a la base de datos exitosa.</p>";
        }
        return "<p>❌ Error: No se pudo establecer la conexión a la base de datos.</p>";
    }
}