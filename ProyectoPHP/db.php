<?php
// db.php
$servername = "localhost"; // Cambia estos valores por los correctos de tu base de datos
$username = "Hector";        // El usuario de la base de datos
$password = "1234";            // La contraseña del usuario
$dbname = "motogp"; // El nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);  // Detener el script si no puede conectar
}
?>
