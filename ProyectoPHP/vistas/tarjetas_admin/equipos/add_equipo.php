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
    $pais = $_POST['pais'];
    $tecnico_principal = $_POST['tecnico_principal'];

    $query = 'INSERT INTO equipos (nombre, pais, tecnico_principal) VALUES (?, ?, ?)';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$nombre, $pais, $tecnico_principal]);

    header("Location: equipos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nuevo Equipo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../../img/Moto_Gp_logo.svg" />
</head>
<body>
    <div class="container mt-4">
        <h2>Añadir Nuevo Equipo</h2>
        <form method="POST" onsubmit="return confirmarAñadir()">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Equipo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="pais" class="form-label">País</label>
                <input type="text" class="form-control" id="pais" name="pais" required>
            </div>
            <div class="mb-3">
                <label for="tecnico_principal" class="form-label">Técnico Principal</label>
                <input type="text" class="form-control" id="tecnico_principal" name="tecnico_principal" required>
            </div>
            <button type="submit" class="btn btn-primary">Añadir Equipo</button>
        </form>

        <!-- Botón para volver a la lista de equipos -->
        <a href="equipos.php" class="btn btn-secondary mt-3">Volver a la lista de equipos</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmarAñadir() {
            return confirm("¿Estás seguro de que deseas añadir este equipo?");
        }
    </script>
</body>
</html>
