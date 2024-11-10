<?php
$host = 'localhost'; // O tu host de base de datos
$dbname = 'motogp';  // Nombre de la base de datos
$username = 'Hector';   // Usuario de la base de datos
$password = '1234';       // Contraseña del usuario

try {
    // Creación de la conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configurar el modo de error de PDO para que las excepciones sean lanzadas
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En caso de error en la conexión, muestra el mensaje
    echo 'Error al conectar a la base de datos: ' . $e->getMessage();
}
?>
