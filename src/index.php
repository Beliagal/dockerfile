<?php
// Código PHP "vainilla" simple para demostrar la conexión a la base de datos

// 1. Configuración de la conexión a la base de datos
// Usamos variables de entorno que se inyectan desde docker-compose.yml
$host = 'db'; // El nombre del servicio de la base de datos en docker-compose
$db   = getenv('MYSQL_DATABASE');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_PASSWORD');
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$connection_status = "Conexión a la Base de Datos: ";

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     $connection_status .= "¡EXITOSA!";

     // 2. Crear una tabla simple si no existe
     $pdo->exec("CREATE TABLE IF NOT EXISTS mensajes (
         id INT AUTO_INCREMENT PRIMARY KEY,
         contenido VARCHAR(255) NOT NULL,
         fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
     )");

     // 3. Insertar un mensaje de prueba si la tabla está vacía
     $stmt = $pdo->query("SELECT COUNT(*) FROM mensajes");
     if ($stmt->fetchColumn() == 0) {
         $pdo->exec("INSERT INTO mensajes (contenido) VALUES ('Hola desde PHP y MySQL en Docker!')");
     }

     // 4. Obtener todos los mensajes
     $stmt = $pdo->query("SELECT * FROM mensajes ORDER BY fecha DESC");
     $mensajes = $stmt->fetchAll();

} catch (\PDOException $e) {
     $connection_status .= "FALLIDA. Error: " . $e->getMessage();
     $mensajes = [];
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aplicación PHP + Nginx + MySQL en Docker</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; }
        .container { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        h2 { color: #555; }
        .status-ok { color: green; font-weight: bold; }
        .status-error { color: red; font-weight: bold; }
        ul { list-style: none; padding: 0; }
        li { background: #e9ecef; margin-bottom: 10px; padding: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Proyecto de Estudiante: PHP, Nginx y MySQL con Docker Compose</h1>
        <p>Este es un ejemplo de aplicación web "vainilla" para demostrar la orquestación de servicios con Docker.</p>

        <h2>Estado del Servicio</h2>
        <p class="<?php echo (strpos($connection_status, 'EXITOSA') !== false) ? 'status-ok' : 'status-error'; ?>">
            <?php echo $connection_status; ?>
        </p>

        <?php if (!empty($mensajes)): ?>
            <h2>Mensajes de la Base de Datos (Tabla 'mensajes')</h2>
            <ul>
                <?php foreach ($mensajes as $mensaje): ?>
                    <li>
                        <strong>ID:</strong> <?php echo htmlspecialchars($mensaje['id']); ?><br>
                        <strong>Contenido:</strong> <?php echo htmlspecialchars($mensaje['contenido']); ?><br>
                        <strong>Fecha:</strong> <?php echo htmlspecialchars($mensaje['fecha']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <h2>Información del Entorno PHP</h2>
        <p>Versión de PHP: <?php echo phpversion(); ?></p>
        <p>Extensiones cargadas: <?php echo implode(', ', get_loaded_extensions()); ?></p>
    </div>
</body>
</html>
