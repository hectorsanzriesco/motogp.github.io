<?php
// Conexion a la base de datos
$host = 'localhost';  // Cambia esto si es necesario
$dbname = 'motogp';   // Nombre de la base de datos
$username = 'Hector';
$password = '1234';

// Crear conexión
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
    exit();
}

// Obtener los datos de los pilotos
$query = 'SELECT id, nombre, nacionalidad, fecha_nacimiento, equipo_id FROM pilotos';  // Consulta ajustada a tu base de datos
$stmt = $pdo->query($query);

// Crear un array con los resultados
$pilotos = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pilotos[] = $row;
}

// Establecer el tipo de contenido como JSON
header('Content-Type: application/json');

// Devolver los datos de los pilotos como JSON
echo json_encode($pilotos);
?>
