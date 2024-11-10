<?php
session_start();  // Iniciar sesión

include('conection.php');

// Verificar si se pasa el ID a través de la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Recuperar los datos de la clasificación que se va a editar
    $query = 'SELECT id, nombre_piloto, temporada, puntos_totales_piloto, posicion_piloto FROM clasificacion WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $clasificacion = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no se encuentra la clasificación con ese ID, redirigir a la lista
    if (!$clasificacion) {
        $_SESSION['mensaje'] = 'Clasificación no encontrada';
        header('Location: clasification.php');
        exit;
    }
}

// Procesar la actualización de la clasificación
if (isset($_POST['update'])) {
    // Obtener los datos del formulario
    $nombre_piloto = $_POST['nombre_piloto'];
    $temporada = $_POST['temporada'];
    $puntos_totales_piloto = $_POST['puntos_totales_piloto'];
    $posicion_piloto = $_POST['posicion_piloto'];

    // Actualizar la clasificación en la base de datos
    $updateQuery = 'UPDATE clasificacion SET nombre_piloto = :nombre_piloto, temporada = :temporada, 
                    puntos_totales_piloto = :puntos_totales_piloto, posicion_piloto = :posicion_piloto 
                    WHERE id = :id';
    $stmt = $pdo->prepare($updateQuery);
    $stmt->bindParam(':nombre_piloto', $nombre_piloto);
    $stmt->bindParam(':temporada', $temporada);
    $stmt->bindParam(':puntos_totales_piloto', $puntos_totales_piloto);
    $stmt->bindParam(':posicion_piloto', $posicion_piloto);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = 'Clasificación actualizada con éxito';
        header('Location: clasification.php');  // Redirigir a la lista de clasificaciones
        exit;
    } else {
        $_SESSION['mensaje'] = 'Hubo un error al actualizar la clasificación';
        header('Location: clasification.php');  // Redirigir a la lista de clasificaciones
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Clasificación - Moto GP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script>
        // Función para confirmar la actualización
        function confirmarActualizacion(event) {
            // Mostrar el cuadro de confirmación
            var confirmacion = confirm("¿Estás seguro de que quieres actualizar esta clasificación?");
            
            // Si el usuario acepta, se envía el formulario, sino no hace nada
            if (!confirmacion) {
                event.preventDefault();  // Evitar que el formulario se envíe
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <!-- Mostrar mensaje de éxito o error en la parte superior de la página -->
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $_SESSION['mensaje']; ?>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <h2 class="my-4">Editar Clasificación</h2>

        <!-- Formulario para editar la clasificación -->
        <form action="" method="POST" id="editForm" onsubmit="confirmarActualizacion(event)">
            <div class="mb-3">
                <label for="nombre_piloto" class="form-label">Nombre del Piloto</label>
                <input type="text" class="form-control" id="nombre_piloto" name="nombre_piloto" value="<?php echo htmlspecialchars($clasificacion['nombre_piloto']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="temporada" class="form-label">Temporada</label>
                <input type="text" class="form-control" id="temporada" name="temporada" value="<?php echo htmlspecialchars($clasificacion['temporada']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="puntos_totales_piloto" class="form-label">Puntos Totales</label>
                <input type="number" class="form-control" id="puntos_totales_piloto" name="puntos_totales_piloto" value="<?php echo htmlspecialchars($clasificacion['puntos_totales_piloto']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="posicion_piloto" class="form-label">Posición</label>
                <input type="number" class="form-control" id="posicion_piloto" name="posicion_piloto" value="<?php echo htmlspecialchars($clasificacion['posicion_piloto']); ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Actualizar Clasificación</button>
        </form>

        <button onclick="window.location.href='clasification.php';" class="btn btn-secondary mt-3">Volver a la Clasificación</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
