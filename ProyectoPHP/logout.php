<?php
// Iniciar sesión
session_start();

// Eliminar todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Eliminar la cookie PHPSESSID configurando su fecha de expiración a un momento en el pasado
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/'); // Establecer la cookie a una fecha pasada para eliminarla
}

// Redirigir al usuario a la página de inicio de sesión o a la página principal
header("Location: index.php"); // O usa la página principal si no tienes un login
exit;
?>
