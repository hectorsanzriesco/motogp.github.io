<?php
// Iniciar sesión (si aún no está iniciada)
session_start();

// Verifica si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    require_once 'conection.php'; // Aquí incluyes tu archivo de conexión a la base de datos

    // Obtener los valores del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $rol = $_POST['rol'];
    $contrasena = $_POST['contrasena'];

    // Validación simple
    $error_message = '';
    $success_message = '';
    
    if (empty($nombre_usuario) || empty($rol) || empty($contrasena)) {
        $error_message = 'Todos los campos son requeridos.';
    } else {
        // Comprobar si el nombre de usuario ya existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE nombre_usuario = ?");
        $stmt->execute([$nombre_usuario]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $error_message = 'No se puede agregar el usuario porque ya existe.';
        } else {
            // Hash de la contraseña antes de guardarla
            $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

            // Intentar insertar en la base de datos
            try {
                $stmt = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, rol, contrasena) VALUES (?, ?, ?)");
                $stmt->execute([$nombre_usuario, $rol, $hashed_password]);

                // Mensaje de éxito
                $success_message = 'Usuario agregado con éxito.';

                // Redirigir después de la inserción exitosa
                header("Location: usuarios.php");
                exit(); // Asegura que no se ejecute más código después de la redirección
            } catch (Exception $e) {
                // Si hay un error inesperado en la base de datos
                $error_message = 'Hubo un error al agregar el usuario: ' . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <!-- Imagen de pestaña -->
    <link rel="shortcut icon" href="../../../img/Moto_Gp_logo.svg" />
    <link rel="stylesheet" href="../../style/style.css">
    <script>
        // Función que muestra un cuadro de confirmación antes de enviar el formulario
        function confirmarAgregarUsuario(event) {
            event.preventDefault(); // Evita que el formulario se envíe de inmediato
            const confirmacion = confirm("¿Estás seguro de que quieres agregar este usuario?");
            if (confirmacion) {
                // Si el usuario confirma, enviar el formulario
                document.getElementById('formAgregarUsuario').submit();
            }
        }

        // Función para confirmar si realmente quieres cancelar
        function confirmarCancelar() {
            const confirmacion = confirm("¿Estás seguro de que deseas cancelar y salir sin guardar?");
            if (confirmacion) {
                // Si el usuario confirma, lo redirigimos a la lista de usuarios
                window.location.href = "usuarios.php";
            }
        }
    </script>
</head>
<body>
    <div class="container mt-4">
        <h3>Agregar Nuevo Usuario</h3>

        <!-- Mensajes de error o éxito -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success"><?= $success_message ?></div>
        <?php endif; ?>

        <!-- Formulario para agregar usuario -->
        <form id="formAgregarUsuario" action="agregar_usuario.php" method="POST">
            <div class="mb-3">
                <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
            </div>

            <div class="mb-3">
                <label for="rol" class="form-label">Rol</label>
                <select class="form-control" id="rol" name="rol" required>
                    <option value="admin">Administrador</option>
                    <option value="usuario">Usuario</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>

            <button type="button" class="btn btn-success" onclick="confirmarAgregarUsuario(event)">Añadir Usuario</button>
            <button type="button" class="btn btn-secondary" onclick="confirmarCancelar()">Cancelar</button>
        </form>
    </div>
</body>
</html>
