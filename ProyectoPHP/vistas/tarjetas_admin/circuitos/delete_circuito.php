<?php
session_start();
include('conexion.php');

if (isset($_POST['id'])) {
    $id_circuito = $_POST['id'];

    // Verificar si hay carreras asociadas al circuito
    $query_check_carreras = 'SELECT COUNT(*) FROM carreras WHERE circuito_id = :id_circuito';
    $stmt = $pdo->prepare($query_check_carreras);
    $stmt->bindParam(':id_circuito', $id_circuito, PDO::PARAM_INT);
    $stmt->execute();

    $count_carreras = $stmt->fetchColumn();

    if ($count_carreras > 0) {
        // Si existen carreras asociadas, no permitir la eliminación
        $_SESSION['mensaje'] = 'No se puede eliminar el circuito porque tiene carreras asociadas.';
    } else {
        // Si no existen carreras asociadas, proceder a eliminar el circuito
        $query_delete_circuito = 'DELETE FROM circuitos WHERE id = :id_circuito';
        $stmt = $pdo->prepare($query_delete_circuito);
        $stmt->bindParam(':id_circuito', $id_circuito, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = 'El circuito ha sido eliminado correctamente.';
        } else {
            $_SESSION['mensaje'] = 'Hubo un error al eliminar el circuito.';
        }
    }
} else {
    $_SESSION['mensaje'] = 'No se especificó el ID del circuito.';
}

// Redirigir de vuelta a la página de circuitos
header('Location: index.php');
exit();
?>
