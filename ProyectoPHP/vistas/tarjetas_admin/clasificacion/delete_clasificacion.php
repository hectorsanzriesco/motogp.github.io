<?php
// Iniciar la sesión para poder mostrar mensajes después de la redirección
session_start();

// Incluir la conexión a la base de datos
include('conection.php');

// Verificar si se ha recibido el parámetro 'id'
if (isset($_POST['id'])) {
    // Recoger el ID de la clasificación a eliminar
    $id = $_POST['id'];

    try {
        // Preparar la consulta SQL para eliminar la clasificación con el ID especificado
        $query = 'DELETE FROM clasificacion WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Si la eliminación es exitosa, guardamos un mensaje en la sesión
            $_SESSION['mensaje'] = 'La clasificación ha sido eliminada correctamente.';
        } else {
            // Si ocurre algún error al ejecutar la consulta
            $_SESSION['mensaje'] = 'Hubo un error al eliminar la clasificación. Intenta nuevamente.';
        }
    } catch (Exception $e) {
        // Si ocurre algún error en el bloque try-catch, mostramos un mensaje de error
        $_SESSION['mensaje'] = 'Error al procesar la solicitud: ' . $e->getMessage();
    }
} else {
    // Si no se ha recibido el ID, también mostramos un error
    $_SESSION['mensaje'] = 'No se ha proporcionado un ID válido para eliminar.';
}

// Redirigir a la página de clasificaciones
header('Location: clasificacion.php');
exit;
?>
