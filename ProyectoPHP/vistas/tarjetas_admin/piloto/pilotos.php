<?php
session_start();  // Iniciar sesión

include('conexion.php');

// Obtener los datos de los pilotos, incluyendo el nombre del equipo
$query = 'SELECT id, nombre, nacionalidad, id_equipo, nombre_equipo, fecha_nacimiento FROM pilotos';
$stmt = $pdo->query($query);
$pilotos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mostrar el mensaje si el piloto fue eliminado
$mensaje = '';
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);  // Eliminar el mensaje después de mostrarlo
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilotos - Moto GP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <!-- Imagen de pestaña -->
    <link rel="shortcut icon" href="../../../img/Moto_Gp_logo.svg" />
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm p-1 mb-5 bg-body rounded sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand disabled" href="../index_admin.html">
                <img src="../../../img/Moto_Gp_logo.svg" alt="motogpLogo" width="90">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-current="page" href="../piloto/pilotos.php">Pilotos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../equipos/equipos.php">Equipos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../circuitos/index.php">Circuitos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../resultados/resultados.php">Resultados Carreras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../clasificacion/clasification.php">Clasificación</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="d-flex justify-content-end align-items-center w-100">
            <p class="mb-0 me-3">Administrador</p>
            <form id="logout-form" action="../../logout.php" method="POST" class="d-flex">
                <button class="btn btn-outline-danger" type="button" onclick="confirmLogout()">Cerrar sesión</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <h2 class="my-4">Lista de Pilotos</h2>

        <!-- Botón para volver atrás a index_admin.html -->
        <button onclick="window.location.href='../index_admin.html';" class="btn btn-secondary mb-3">Volver Atrás</button>

        <!-- Mostrar mensaje de éxito o error -->
        <?php if ($mensaje): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <!-- Tabla de pilotos -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Nacionalidad</th>
                    <th scope="col">Nombre del Equipo</th>
                    <th scope="col">Fecha de Nacimiento</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($pilotos) {
                    foreach ($pilotos as $piloto) {
                        echo '
                        <tr>
                            <td>' . htmlspecialchars($piloto['nombre']) . '</td>
                            <td>' . htmlspecialchars($piloto['nacionalidad']) . '</td>
                            <td>' . htmlspecialchars($piloto['nombre_equipo']) . '</td>
                            <td>' . htmlspecialchars($piloto['fecha_nacimiento']) . '</td>
                            <td>
                                <!-- Botón de Editar -->
                                <a href="edit_piloto.php?id=' . $piloto['id'] . '" class="btn btn-warning btn-sm">Editar</a>
                                <!-- Botón Añadir Nuevo Piloto entre editar y eliminar -->
                                <a href="add_piloto.php" class="btn btn-success btn-sm mx-2">Añadir</a>
                                <!-- Formulario de eliminar -->
                                <form action="delete_piloto.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="' . $piloto['id'] . '">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este piloto?\')">Eliminar</button>
                                </form>
                            </td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">No se encontraron pilotos.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>