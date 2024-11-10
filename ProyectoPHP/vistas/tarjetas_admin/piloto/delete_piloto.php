<?php
// Incluir el archivo de conexión
include_once('conexion.php');

// Comprobar si el ID del piloto se ha pasado correctamente a través de POST
if (isset($_POST['id'])) {
    // Obtener el ID del piloto que vamos a eliminar
    $piloto_id = $_POST['id'];

    try {
        // Iniciar una transacción para garantizar que las operaciones se hagan de forma atómica
        $pdo->beginTransaction();

        // 1. Eliminar los resultados de carrera asociados al piloto en la tabla 'resultados_carreras'
        $deleteResultadosQuery = 'DELETE FROM resultados_carreras WHERE piloto_id = :piloto_id';
        $stmt = $pdo->prepare($deleteResultadosQuery);
        $stmt->bindParam(':piloto_id', $piloto_id, PDO::PARAM_INT);
        $stmt->execute();

        // 2. Eliminar las clasificaciones asociadas al piloto en la tabla 'clasificacion_pilotos'
        $deleteClasificacionQuery = 'DELETE FROM clasificacion_pilotos WHERE piloto_id = :piloto_id';
        $stmt = $pdo->prepare($deleteClasificacionQuery);
        $stmt->bindParam(':piloto_id', $piloto_id, PDO::PARAM_INT);
        $stmt->execute();

        // 3. Ahora eliminar el piloto de la tabla 'pilotos'
        $deletePilotoQuery = 'DELETE FROM pilotos WHERE id = :id';
        $stmt = $pdo->prepare($deletePilotoQuery);
        $stmt->bindParam(':id', $piloto_id, PDO::PARAM_INT);
        $stmt->execute();

        // Confirmar los cambios
        $pdo->commit();

        // Redirigir al listado de pilotos o mostrar mensaje de éxito
        session_start();  // Asegúrate de iniciar la sesión para almacenar mensajes
        $_SESSION['mensaje'] = 'Piloto eliminado correctamente.';
        header('Location: pilotos.php'); // Redirige a la página de listado de pilotos
        exit();

    } catch (Exception $e) {
        // Si ocurre algún error, hacemos un rollback para deshacer las operaciones
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    // Si no se pasó un ID de piloto por POST
    echo "No se ha proporcionado un ID de piloto.";
}
?>
