<?php
session_start();

include('db.php');

if (isset($_SESSION['nombre_usuario'])) {
    if ($_SESSION['rol'] == 'admin') {
        header("Location: vistas/tarjetas_admin/index_admin.html");
        exit;
    } else {
        header("Location: vistas/index_users.html");
        exit;
    }
}

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
} else {
    $error_message = "";
}

if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
} else {
    $success_message = "";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'], $_POST['password'])) {
    $nombre_usuario = $_POST['username'];
    $password = $_POST['password'];

    if (empty($nombre_usuario) || empty($password)) {
        $error_message = "Por favor, ingresa tu usuario y contraseña.";
    } else {
        if ($conn) {
            $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $nombre_usuario);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if (password_verify($password, $row['contrasena'])) {
                    $_SESSION['nombre_usuario'] = $row['nombre_usuario'];
                    $_SESSION['rol'] = $row['rol'];  // Guardar el rol del usuario

                    if ($row['rol'] == 'admin') {
                        header("Location: vistas/tarjetas_admin/index_admin.html");
                        exit;
                    } else {
                        header("Location: vistas/index_users.html");
                        exit;
                    }
                } else {
                    $error_message = "Nombre de usuario o contraseña incorrectos.";
                }
            } else {
                $error_message = "Nombre de usuario o contraseña incorrectos.";
            }

            $stmt->close();
            $conn->close();
        } else {
            $error_message = "Error de conexión a la base de datos.";
        }
    }
}

// Lógica para el registro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre_usuario'], $_POST['contrasena'], $_POST['rol'])) {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    if (empty($nombre_usuario) || empty($contrasena) || empty($rol)) {
        $error_message = "Por favor, completa todos los campos.";
    } else {
        if ($conn) {
            // Verificar si el usuario ya existe
            $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $nombre_usuario);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Si el usuario ya existe, mostramos un mensaje de error
                $error_message = "El nombre de usuario ya existe, por favor elige otro.";
            } else {
                // Si el usuario no existe, proceder a registrar
                $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
                $sql = "INSERT INTO usuarios (nombre_usuario, contrasena, rol) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $nombre_usuario, $hashed_password, $rol);
                if ($stmt->execute()) {
                    $_SESSION['success_message'] = "Registro exitoso.";
                    header("Location: index.php");  // Redirigir al login después de un registro exitoso
                    exit;
                } else {
                    $error_message = "Error al registrar el usuario.";
                }
            }

            $stmt->close();
            $conn->close();
        } else {
            $error_message = "Error de conexión a la base de datos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro</title>
    <link rel="shortcut icon" href="./img/Moto_Gp_logo.svg" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <style>
        img {
            position: absolute;
            margin: 0 auto 20px;
            width: 150px;
            top: 50px;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: rgb(255, 0, 0);
            background: linear-gradient(90deg,
                    #D90042 0%,
                    rgba(0, 0, 0, 1) 30%,
                    rgba(252, 252, 252, 1) 33%,
                    rgba(255, 255, 255, 1) 67%,
                    rgba(0, 0, 0, 1) 70%,
                    #D90042 100%);
        }

        .container {
            width: 300px;
            background-color: white;
            padding: 30px;
            padding-right: 40px;
            border-radius: 8px;
            box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.47);
        }

        h2 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .switch-form {
            text-align: center;
            margin-top: 10px;
        }

        .switch-form a {
            text-decoration: none;
            color: #007BFF;
        }

        .switch-form a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
            display: none;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <!-- Logotipo Moto GP -->
    <img src="./img/Moto_Gp_logo.svg" alt="Moto GP Logo">

    <!-- Formulario de Login -->
    <div class="container" id="form-container">
        <form id="login-form" action="index.php" method="POST">
            <h2>Login</h2>
            <div class="form-group">
                <input type="text" id="username" name="username" required placeholder="Nombre de Usuario"><br>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" required placeholder="Contraseña"><br>
            </div>
            <button type="submit">Iniciar sesión</button>

            <!-- Mostrar el mensaje de error debajo del botón -->
            <?php if (!empty($error_message)): ?>
                <div class="error-message" id="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <div class="switch-form">
                <p>No tienes cuenta? <a href="javascript:void(0);" onclick="toggleForm()">Registrarse</a></p>
            </div>
        </form>

        <!-- Formulario de Registro (oculto por defecto) -->
        <form id="register-form" action="index.php" method="POST" style="display:none;">
            <h2>Registrarse</h2>
            <div class="form-group">
                <input type="text" id="register-name" name="nombre_usuario" required placeholder="Nombre de usuario">
            </div>
            <div class="form-group">
                <input type="password" id="register-password" name="contrasena" required placeholder="Contraseña">
            </div>
            <div class="form-group">
                <label for="role">Rol</label>
                <select id="role" name="rol" required>
                    <option value="usuario">Usuario</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            <button type="submit">Registrarse</button>

            <!-- Mostrar el mensaje de error debajo del botón -->
            <?php if (!empty($error_message)): ?>
                <div class="error-message" id="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <div class="switch-form">
                <p>¿Ya tienes cuenta? <a href="javascript:void(0);" onclick="toggleForm()">Iniciar sesión</a></p>
            </div>
        </form>
    </div>

    <script>
        // Función para alternar entre el formulario de login y registro
        function toggleForm() {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');

            if (loginForm.style.display === 'none') {
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
            } else {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
            }
        }

        // Si hay un mensaje de error, se oculta después de 4 segundos
        window.onload = function() {
            const errorMessage = document.getElementById('error-message');
            if (errorMessage && errorMessage.innerHTML.trim() !== '') {
                errorMessage.style.display = 'block';
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 4000);
            }
        }
    </script>
</body>

</html>
