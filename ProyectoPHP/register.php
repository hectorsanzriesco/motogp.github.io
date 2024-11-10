<?php
session_start(); // Asegúrate de que la sesión esté iniciada

// Incluir la conexión a la base de datos
include('db.php');

// Verificar si el formulario ha sido enviado con el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si los campos existen y no están vacíos en $_POST
    if (isset($_POST['nombre_usuario'], $_POST['contrasena'], $_POST['rol']) &&
        !empty($_POST['nombre_usuario']) && !empty($_POST['contrasena']) && !empty($_POST['rol'])) {
        
        // Obtener los datos del formulario
        $nombre_usuario = $_POST['nombre_usuario'];
        $contrasena = $_POST['contrasena'];
        $rol = $_POST['rol'];

        // Comprobar si el nombre de usuario ya existe en la base de datos
        $sql_check = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
        
        if ($stmt_check = $conn->prepare($sql_check)) {
            $stmt_check->bind_param("s", $nombre_usuario);
            $stmt_check->execute();
            $result = $stmt_check->get_result();

            if ($result->num_rows > 0) {
                // Guardar mensaje de error en la sesión si el usuario ya existe
                $_SESSION['mensaje'] = "El nombre de usuario ya existe.";
                $stmt_check->close();
                $conn->close();
                header("Location: register.php");
                exit;
            } else {
                // Registrar al nuevo usuario
                $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
                $sql_insert = "INSERT INTO usuarios (nombre_usuario, contrasena, rol, fecha_registro) VALUES (?, ?, ?, NOW())";
                
                if ($stmt_insert = $conn->prepare($sql_insert)) {
                    $stmt_insert->bind_param("sss", $nombre_usuario, $contrasena_hash, $rol);

                    if ($stmt_insert->execute()) {
                        // Guardar mensaje de éxito en la sesión
                        $_SESSION['mensaje'] = "Registro exitoso. Ahora puedes iniciar sesión.";
                        header("Location: index.php");
                    } else {
                        // Guardar mensaje de error en la sesión al registrar
                        $_SESSION['mensaje'] = "Error al registrar el usuario. Intenta de nuevo.";
                        header("Location: register.php");
                    }

                    // Cerrar el statement de inserción
                    $stmt_insert->close();
                } else {
                    // Guardar mensaje de error en la sesión si hay un error en la preparación de la consulta
                    $_SESSION['mensaje'] = "Error en la preparación de la consulta.";
                    header("Location: register.php");
                }
            }

            // Cerrar el statement de verificación de usuario
            $stmt_check->close();
        } else {
            // Guardar mensaje de error en la sesión si hay un error en la preparación de la consulta
            $_SESSION['mensaje'] = "Error en la preparación de la consulta.";
            header("Location: register.php");
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
    } else {
        // Guardar mensaje de error en la sesión si algún campo está vacío
        $_SESSION['mensaje'] = "Por favor, rellena todos los campos.";
        header("Location: register.php");
    }
}
?>