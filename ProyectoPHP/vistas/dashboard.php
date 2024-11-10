<?php
// Iniciar sesión
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    // Si no está autenticado, redirigir al inicio de sesión
    header("Location: ../login.php");
    exit;
}

// Si está autenticado, mostrar el contenido de la página
echo "Bienvenido, " . $_SESSION['username'] . "!";
?>
