<?php
// Verifica si se ha pasado el ID del usuario
if (isset($_POST['id'])) {
    $id = $_POST['id'];

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

    // Consulta SQL para eliminar el usuario por su ID
    $sql = "DELETE FROM usuarios WHERE id = ?";
    
    // Preparar la consulta
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id); // "i" indica que el parámetro es un entero (ID)
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir a la página de usuarios después de la eliminación
            header("Location: usuarios.php?mensaje=Usuario%20eliminado%20con%20éxito");
            exit;
        } else {
            echo "Error al eliminar el usuario: " . $conn->error;
        }
        
        // Cerrar la sentencia
        $stmt->close();
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "No se proporcionó un ID válido para eliminar.";
}
?>
