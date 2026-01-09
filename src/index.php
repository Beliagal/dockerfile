<?php

# src/index.php

// Mantiene el código limpio y separa la lógica de presentación
require 'DatabaseService.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Entorno en Dockerfiles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        p {
            font-size: 16px;
            color: #666;
        }
    </style>
</head>

<body>
    <h1>¡Hola Mundo!</h1>
    <p>Esta es una aplicación PHP ejecutándose en un contenedor Docker (Versión <?php echo phpversion(); ?>).</p>

    <div class="info">
        <h3>Estado del Servicio de Base de Datos:</h3>
        <?php
        try {
            // La lógica de negocio se delega al servicio
            $dbService = new DatabaseService();
            echo $dbService->getStatus();
        } catch (Exception $e) {
            // Manejo de errores de conexión/configuración
            echo "<p style='color: red;'>❌ " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>
</body>
</html>