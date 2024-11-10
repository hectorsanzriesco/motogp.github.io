<?php
include('conexion.php'); // Incluye la conexión a la base de datos

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $descripcion = $_POST['descripcion'];
    $longitud = $_POST['longitud'];
    $tipo = $_POST['tipo'];

    // Preparar la consulta para insertar los datos
    $sql = "INSERT INTO circuitos (nombre, ubicacion, descripcion, longitud, tipo) 
            VALUES (:nombre, :ubicacion, :descripcion, :longitud, :tipo)";
    
    // Usamos PDO para ejecutar la consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':ubicacion', $ubicacion);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':longitud', $longitud);
    $stmt->bindParam(':tipo', $tipo);

    try {
        // Ejecutar la consulta
        $stmt->execute();

        // Redirigir al listado de circuitos
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        // En caso de error, mostrar el mensaje
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nuevo Circuito</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h2 class="my-4">Añadir Nuevo Circuito</h2>

        <form method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="ubicacion" class="form-label">Ubicación:</label>
                <input type="text" name="ubicacion" id="ubicacion" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="longitud" class="form-label">Longitud (km):</label>
                <input type="number" name="longitud" id="longitud" class="form-control" step="0.1" required>
            </div>

            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Circuito:</label>
                <select name="tipo" id="tipo" class="form-select" required>
                    <option value="urbano">Urbano</option>
                    <option value="permanente">Permanente</option>
                    <option value="mixto">Mixto</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Guardar</button>
        </form>

        <a href="index.php" class="btn btn-secondary mt-3">Volver a la lista de circuitos</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
