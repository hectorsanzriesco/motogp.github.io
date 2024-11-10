<?php
// Iniciar sesión
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    // Si no está autenticado, redirigir al login
    header("Location: ../login.html");
    exit;
}

// Si está autenticado, mostrar el perfil del usuario
echo "Este es tu perfil, " . $_SESSION['username'] . "!";
?>
