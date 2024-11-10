<?php
$host = 'localhost';  // Cambia esto si es necesario
$dbname = 'motogp';   // Nombre de la base de datos
$username = 'Hector'; // Usuario de la base de datos
$password = '1234';   // Contraseña de la base de datos

try {
    // Crear conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si hay un error de conexión
    echo 'Error de conexión: ' . $e->getMessage();
    exit();
}
?>
