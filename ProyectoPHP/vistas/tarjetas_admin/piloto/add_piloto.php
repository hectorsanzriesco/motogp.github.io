<?php
// Configuración de la base de datos
$host = 'localhost';    
$dbname = 'motogp';    
$username = 'Hector';     
$password = '1234';         

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $nacionalidad = $_POST['nacionalidad'];
    $equipo_id = $_POST['equipo_id'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    $query = 'INSERT INTO pilotos (nombre, nacionalidad, equipo_id, fecha_nacimiento) VALUES (?, ?, ?, ?)';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$nombre, $nacionalidad, $equipo_id, $fecha_nacimiento]);

    header("Location: pilotos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Piloto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../../img/Moto_Gp_logo.svg" />
</head>
<body>
    <div class="container mt-4">
        <h2>Añadir Nuevo Piloto</h2>
        <form method="POST" onsubmit="return confirmarAñadir()">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="nacionalidad" class="form-label">Nacionalidad</label>
                <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" required>
            </div>
            <div class="mb-3">
                <label for="equipo_id" class="form-label">Equipo ID</label>
                <input type="number" class="form-control" id="equipo_id" name="equipo_id" required>
            </div>
            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <button type="submit" class="btn btn-primary">Añadir Piloto</button>
        </form>

        <!-- Botón para volver a la lista de pilotos -->
        <a href="pilotos.php" class="btn btn-secondary mt-3">Volver a la lista de pilotos</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmarAñadir() {
            return confirm("¿Estás seguro de que deseas añadir este piloto?");
        }
    </script>
</body>
</html>
