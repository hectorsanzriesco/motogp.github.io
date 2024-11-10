<?php
// Habilitar mensajes de error para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir la conexión a la base de datos
include('db.php');
session_start();  // Iniciar sesión

// Verificar si el usuario ya está logueado
if (isset($_SESSION['nombre_usuario'])) {
    if ($_SESSION['rol'] == 'admin') {
        header("Location: vistas/tarjetas_admin/index_admin.html");
        exit;
    } else {
        header("Location: vistas/index_users.html");
        exit;
    }
}

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nombre_usuario'], $_POST['contrasena'])) {
        $nombre_usuario = $_POST['nombre_usuario'];
        $password = $_POST['contrasena'];

        if (empty($nombre_usuario) || empty($password)) {
            header("Location: index.php?mensaje=Por%20favor,%20ingresa%20tu%20usuario%20y%20contraseña");
            exit;
        } else {
            $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $nombre_usuario);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if (password_verify($password, $row['contrasena'])) {
                        $_SESSION['nombre_usuario'] = $row['nombre_usuario'];
                        $_SESSION['rol'] = $row['rol'];

                        if ($row['rol'] == 'admin') {
                            header("Location: vistas/tarjetas_admin/index_admin.html");
                        } else {
                            header("Location: vistas/index_users.html");
                        }
                        exit;
                    } else {
                        header("Location: index.php?mensaje=Nombre%20de%20usuario%20o%20contraseña%20incorrectos");
                        exit;
                    }
                } else {
                    header("Location: index.php?mensaje=Nombre%20de%20usuario%20o%20contraseña%20incorrectos");
                    exit;
                }

                // Cerrar el statement si fue creado
                if ($stmt) {
                    $stmt->close();
                }
            } else {
                header("Location: index.php?mensaje=Error%20en%20la%20consulta%20de%20usuario");
                exit;
            }

            // Cerrar la conexión si fue creada
            if ($conn) {
                $conn->close();
            }
        }
    } else {
        header("Location: index.php?mensaje=Por%20favor,%20ingresa%20tu%20usuario%20y%20contraseña");
        exit;
    }
}
?>
