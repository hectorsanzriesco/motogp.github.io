<?php
// Iniciar la sesión
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "Hector";
$password = "1234";
$dbname = "motogp";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el ID del usuario está presente en la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obtener los datos del usuario
    $sql = "SELECT id, nombre_usuario, rol, fecha_registro FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Bind del parámetro
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el usuario
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        die("Usuario no encontrado.");
    }
} else {
    die("ID de usuario no proporcionado.");
}

// Manejo de la actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $rol = $_POST['rol'];
    $fecha_registro = $_POST['fecha_registro'];

    // Consulta para actualizar los datos del usuario
    $sql_update = "UPDATE usuarios SET nombre_usuario = ?, rol = ?, fecha_registro = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssi", $nombre_usuario, $rol, $fecha_registro, $id);
    $stmt_update->execute();

    // Establecer la variable de sesión para indicar que el usuario fue modificado
    $_SESSION['usuario_modificado'] = true;

    // Redirigir después de actualizar
    header("Location: editar_usuario.php?id=" . $id);
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Moto GP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <!-- Imagen de pestaña -->
    <link rel="shortcut icon" href="../../../img/Moto_Gp_logo.svg" />
    <link rel="stylesheet" href="../../style/style.css">

    <!-- Script de confirmación -->
    <script>
        // Función de confirmación para guardar los cambios
        function confirmSave() {
            return confirm("¿Estás seguro de que deseas guardar los cambios?");
        }

        // Función de confirmación para cancelar
        function confirmarCancelar() {
            const confirmacion = confirm("¿Estás seguro de que deseas cancelar y perder los cambios?");
            if (confirmacion) {
                // Mostrar alerta de cancelación
                alert("Se ha cancelado la edición del usuario");
                // Redirigir a la lista de usuarios
                window.location.href = "usuarios.php";
            }
            // Si el usuario cancela la confirmación, no hacer nada
        }
    </script>
</head>

<body>
    <!-- NavBar -->
    <nav class="navbar navbar-expand-lg shadow-sm p-1 mb-5 bg-body rounded sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand disabled" href="./index_admin.html">
                <img src="../../../img/Moto_Gp_logo.svg" alt="motogplogo" width="90">
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <h3>Editar Usuario</h3>

        <!-- Verificar si la variable de sesión para la modificación existe y mostrar una alerta -->
        <?php
        if (isset($_SESSION['usuario_modificado']) && $_SESSION['usuario_modificado'] === true) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Éxito!</strong> El usuario fue modificado correctamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            // Eliminar la variable de sesión después de mostrar la alerta
            unset($_SESSION['usuario_modificado']);
        }
        ?>

        <!-- Formulario para editar el usuario -->
        <form method="POST" action="editar_usuario.php?id=<?php echo $usuario['id']; ?>" onsubmit="return confirmSave()">
            <div class="mb-3">
                <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario"
                    value="<?php echo htmlspecialchars($usuario['nombre_usuario']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="rol" class="form-label">Rol</label>
                <select class="form-select" id="rol" name="rol" required>
                    <option value="admin" <?php if ($usuario['rol'] == 'admin') echo 'selected'; ?>>Administrador</option>
                    <option value="usuario" <?php if ($usuario['rol'] == 'usuario') echo 'selected'; ?>>Usuario</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                <input type="date" class="form-control" id="fecha_registro" name="fecha_registro"
                    value="<?php echo $usuario['fecha_registro']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <!-- Botón con confirmación antes de redirigir -->
            <button type="button" class="btn btn-secondary" onclick="confirmarCancelar()">Cancelar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
