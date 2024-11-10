<?php
// Configuración de la base de datos
$host = 'localhost';    
$dbname = 'motogp';    
$username = 'Hector';     
$password = '1234';         

// Crear conexión PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error de conexión: ' . $e->getMessage();
    exit();
}

// Verificar si se ha pasado un ID por la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obtener los datos del piloto a editar junto con el nombre del equipo
    $stmt = $pdo->prepare("SELECT pilotos.*, equipos.nombre AS nombre_equipo 
                           FROM pilotos 
                           JOIN equipos ON pilotos.id_equipo = equipos.id 
                           WHERE pilotos.id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $piloto = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el piloto existe
    if (!$piloto) {
        echo "Piloto no encontrado.";
        exit();
    }

    // Consulta para obtener todos los equipos para el menú desplegable
    $equiposStmt = $pdo->prepare("SELECT id, nombre FROM equipos");
    $equiposStmt->execute();
    $equipos = $equiposStmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Si no se pasa el ID, redirigir a la página principal de pilotos
    header('Location: pilotos.php');
    exit();
}

// Verificar si el formulario se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $nacionalidad = $_POST['nacionalidad'];
    $id_equipo = $_POST['id_equipo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    // Actualizar los datos del piloto en la base de datos
    $updateQuery = "UPDATE pilotos 
                    SET nombre = :nombre, nacionalidad = :nacionalidad, id_equipo = :id_equipo, fecha_nacimiento = :fecha_nacimiento 
                    WHERE id = :id";
    $stmt = $pdo->prepare($updateQuery);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':nacionalidad', $nacionalidad);
    $stmt->bindParam(':id_equipo', $id_equipo);
    $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        // Redirigir con mensaje de éxito
        header('Location: pilotos.php?message=Piloto actualizado con éxito');
        exit();
    } else {
        // En caso de error
        echo "Hubo un error al actualizar los datos del piloto.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Piloto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../../img/Moto_Gp_logo.svg" />
</head>

<body>

    <div class="container mt-5">
        <h2>Editar Piloto</h2>
        
        <!-- Formulario de edición del piloto -->
        <form method="POST" action="" onsubmit="return confirmarActualizacion()">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $piloto['nombre']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="nacionalidad" class="form-label">Nacionalidad</label>
                <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" value="<?php echo $piloto['nacionalidad']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="id_equipo" class="form-label">Equipo</label>
                <select class="form-control" id="id_equipo" name="id_equipo" required>
                    <?php foreach ($equipos as $equipo): ?>
                        <option value="<?php echo $equipo['id']; ?>" <?php echo $equipo['id'] == $piloto['id_equipo'] ? 'selected' : ''; ?>>
                            <?php echo $equipo['nombre']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $piloto['fecha_nacimiento']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Piloto</button>
        </form>
        
        <!-- Botón para volver -->
        <a href="pilotos.php" class="btn btn-secondary mt-3">Volver a la lista de pilotos</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmarActualizacion() {
            return confirm("¿Estás seguro de que deseas actualizar este piloto?");
        }
    </script>

</body>

</html>
