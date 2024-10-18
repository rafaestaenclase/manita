<?php
// Establecer las credenciales de la base de datos
$host = '127.0.0.1';
$dbname = 'manita';
$username = 'root';
$password = '';

// Crear una instancia de conexión PDO
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Manejar el error de conexión a la base de datos
    echo "Error de conexión a la base de datos: " . $e->getMessage();
    exit();
}
?>