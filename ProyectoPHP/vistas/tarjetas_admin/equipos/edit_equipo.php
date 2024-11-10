<?php
session_start();  // Iniciar sesión
include('conexion.php');

// Verificar si se ha pasado un id por la URL
if (isset($_GET['id'])) {
    $id_equipo = $_GET['id'];

    // Obtener los datos del equipo por el id
    $query = 'SELECT nombre, pais, tecnico_principal FROM equipos WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id_equipo]);
    $equipo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$equipo) {
        // Si no se encuentra el equipo, redirigir o mostrar un error
        $_SESSION['mensaje'] = 'Equipo no encontrado';
        header('Location: equipos.php');
        exit;
    }
} else {
    // Si no se pasa un id, redirigir o mostrar un error
    $_SESSION['mensaje'] = 'No se ha especificado el equipo';
    header('Location: equipos.php');
    exit;
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $pais = $_POST['pais'];
    $tecnico_principal = $_POST['tecnico_principal'];

    // Actualizar los datos del equipo
    $updateQuery = 'UPDATE equipos SET nombre = :nombre, pais = :pais, tecnico_principal = :tecnico_principal WHERE id = :id';
    $stmt = $pdo->prepare($updateQuery);
    $stmt->execute([
        'nombre' => $nombre,
        'pais' => $pais,
        'tecnico_principal' => $tecnico_principal,
        'id' => $id_equipo
    ]);

    // Redirigir a la lista de pilotos (pilotos.php) con un mensaje de éxito
    $_SESSION['mensaje'] = 'Equipo actualizado con éxito';
    header('Location: equipos.php');  // Redirigir a pilotos.php
    exit;
}

// Obtener todos los equipos para mostrar en el desplegable
$queryAll = 'SELECT id, nombre FROM equipos';
$stmtAll = $pdo->query($queryAll);
$equiposDisponibles = $stmtAll->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Equipo - Moto GP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script>
        // Función para confirmar si se desean guardar los cambios
        function confirmarGuardar(event) {
            if (!confirm("¿Estás seguro de que deseas guardar los cambios?")) {
                event.preventDefault();  // Cancelar el envío del formulario
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2 class="my-4">Editar Equipo</h2>

        <!-- Mostrar mensaje de éxito o error -->
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $_SESSION['mensaje']; ?>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <form method="POST" onsubmit="confirmarGuardar(event)">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Equipo</label>
                <select class="form-control" id="nombre" name="nombre" required>
                    <option value="" disabled>Seleccione un equipo</option>
                    <?php
                    // Mostrar todos los equipos disponibles en el desplegable
                    foreach ($equiposDisponibles as $equipoDisponible) {
                        $selected = ($equipo['nombre'] == $equipoDisponible['nombre']) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($equipoDisponible['nombre']) . '" ' . $selected . '>' . htmlspecialchars($equipoDisponible['nombre']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="pais" class="form-label">País</label>
                <input type="text" class="form-control" id="pais" name="pais" value="<?php echo htmlspecialchars($equipo['pais']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="tecnico_principal" class="form-label">Técnico Principal</label>
                <input type="text" class="form-control" id="tecnico_principal" name="tecnico_principal" value="<?php echo htmlspecialchars($equipo['tecnico_principal']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>

        <!-- Botón para volver atrás -->
        <a href="equipos.php" class="btn btn-secondary mt-3">Volver a la lista de equipos</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
