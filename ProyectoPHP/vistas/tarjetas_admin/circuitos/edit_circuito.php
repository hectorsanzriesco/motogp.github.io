<?php
include('conexion.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = 'SELECT * FROM circuitos WHERE id = ?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $circuito = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$circuito) {
        echo "Circuito no encontrado.";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $ubicacion = $_POST['ubicacion'];
        $longitud_km = $_POST['longitud_km'];
        $numero_curvas = $_POST['numero_curvas'];

        // Actualizar la base de datos
        $query = 'UPDATE circuitos SET nombre = ?, ubicacion = ?, longitud_km = ?, numero_curvas = ? WHERE id = ?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([$nombre, $ubicacion, $longitud_km, $numero_curvas, $id]);

        $_SESSION['mensaje'] = 'Circuito actualizado correctamente.';
        header("Location: index.php");
        exit();
    }
} else {
    echo "ID no especificado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Circuito</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <!-- Imagen de pestaña -->
    <link rel="shortcut icon" href="../../../img/Moto_Gp_logo.svg" />

    <script>
        // Función para confirmar la acción de actualizar el circuito
        function confirmarActualizar() {
            return confirm('¿Estás seguro de que deseas actualizar este circuito?');
        }
    </script>
</head>

<body>

    <div class="container">
        <h2 class="my-4">Editar Circuito</h2>

        <form method="POST" onsubmit="return confirmarActualizar();">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $circuito['nombre']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="ubicacion" class="form-label">Ubicación:</label>
                <input type="text" name="ubicacion" id="ubicacion" class="form-control" value="<?php echo $circuito['ubicacion']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="longitud_km" class="form-label">Longitud (km):</label>
                <input type="number" name="longitud_km" id="longitud_km" class="form-control" value="<?php echo $circuito['longitud_km']; ?>" required step="0.1">
            </div>

            <div class="mb-3">
                <label for="numero_curvas" class="form-label">Número de Curvas:</label>
                <input type="number" name="numero_curvas" id="numero_curvas" class="form-control" value="<?php echo $circuito['numero_curvas']; ?>" required>
            </div>

            <button type="submit" class="btn btn-warning">Actualizar Circuito</button>
        </form>

        <a href="index.php" class="btn btn-secondary mt-3">Volver a la lista</a>
    </div>

</body>

</html>