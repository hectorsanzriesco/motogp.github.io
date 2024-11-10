<?php
session_start();
include('conection.php');

// Verificar si se ha pasado un ID por la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del resultado a editar
    $stmt = $pdo->prepare("SELECT * FROM resultados_carreras WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el resultado existe
    if (!$resultado) {
        echo "Resultado no encontrado.";
        exit();
    }
} else {
    // Si no se pasa el ID, redirigir a la página principal de resultados
    header('Location: resultados.php');
    exit();
}

// Verificar si el formulario se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $nombre_carrera = $_POST['nombre_carrera'];
    $nombre_piloto = $_POST['nombre_piloto'];
    $posicion = $_POST['posicion'];
    $tiempo = $_POST['tiempo'];
    $puntos = $_POST['puntos'];

    // Actualizar el resultado en la base de datos
    $updateQuery = "UPDATE resultados_carreras SET nombre_carrera = :nombre_carrera, nombre_piloto = :nombre_piloto, posicion = :posicion, tiempo = :tiempo, puntos = :puntos WHERE id = :id";
    $stmt = $pdo->prepare($updateQuery);
    $stmt->bindParam(':nombre_carrera', $nombre_carrera);
    $stmt->bindParam(':nombre_piloto', $nombre_piloto);
    $stmt->bindParam(':posicion', $posicion);
    $stmt->bindParam(':tiempo', $tiempo);
    $stmt->bindParam(':puntos', $puntos);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        // Redirigir con mensaje de éxito
        $_SESSION['mensaje'] = 'Resultado actualizado con éxito';
        header('Location: resultados.php');
        exit();
    } else {
        // En caso de error
        echo "Hubo un error al actualizar el resultado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Resultado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../img/Moto_Gp_logo.svg" />
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Resultado</h2>

        <!-- Formulario de edición del resultado -->
        <form method="POST" action="" onsubmit="return confirmarActualizacion()">
            <div class="mb-3">
                <label for="nombre_carrera" class="form-label">Nombre de la Carrera</label>
                <input type="text" class="form-control" id="nombre_carrera" name="nombre_carrera" value="<?php echo $resultado['nombre_carrera']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="nombre_piloto" class="form-label">Nombre del Piloto</label>
                <input type="text" class="form-control" id="nombre_piloto" name="nombre_piloto" value="<?php echo $resultado['nombre_piloto']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="posicion" class="form-label">Posición</label>
                <input type="number" class="form-control" id="posicion" name="posicion" value="<?php echo $resultado['posicion']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="tiempo" class="form-label">Tiempo</label>
                <input type="text" class="form-control" id="tiempo" name="tiempo" value="<?php echo $resultado['tiempo']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="puntos" class="form-label">Puntos</label>
                <input type="number" class="form-control" id="puntos" name="puntos" value="<?php echo $resultado['puntos']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Resultado</button>
        </form>

        <!-- Botón para volver -->
        <a href="resultados.php" class="btn btn-secondary mt-3">Volver a la lista de resultados</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmarActualizacion() {
            return confirm("¿Estás seguro de que deseas actualizar este resultado?");
        }
    </script>
</body>
</html>
