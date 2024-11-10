<?php
session_start();  // Iniciar sesión

include('conection.php');

// Obtener los datos de la clasificación
$query = 'SELECT id, nombre_piloto, temporada, puntos_totales_piloto, posicion_piloto FROM clasificacion ORDER BY temporada DESC, posicion_piloto ASC';
$stmt = $pdo->query($query);
$clasificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mostrar el mensaje si hubo una acción
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
    <title>Clasificación - Moto GP</title>
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
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="../piloto/pilotos.php">Pilotos</a></li>
                    <li class="nav-item"><a class="nav-link active" href="../equipos/equipos.php">Equipos</a></li>
                    <li class="nav-item"><a class="nav-link active" href="../circuitos/index.php">Circuitos</a></li>
                    <li class="nav-item"><a class="nav-link active" href="../resultados/resultados.php">Resultados Carreras</a></li>
                    <li class="nav-item"><a class="nav-link disabled" href="../clasificacion/clasification.php">Clasificación</a></li>
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
        <h2 class="my-4">Clasificación General</h2>

        <!-- Botón para volver atrás a index_admin.html -->
        <button onclick="window.location.href='../index_admin.html';" class="btn btn-secondary mb-3">Volver Atrás</button>

        <!-- Mostrar mensaje de éxito o error -->
        <?php if ($mensaje): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <!-- Tabla de clasificación -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Posición</th>
                    <th scope="col">Piloto</th>
                    <th scope="col">Puntos Totales</th>
                    <th scope="col">Temporada</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($clasificaciones) {
                    foreach ($clasificaciones as $clasificacion) {
                        echo '
                        <tr>
                            <td>' . htmlspecialchars($clasificacion['posicion_piloto']) . '</td>
                            <td>' . htmlspecialchars($clasificacion['nombre_piloto']) . '</td>
                            <td>' . htmlspecialchars($clasificacion['puntos_totales_piloto']) . '</td>
                            <td>' . htmlspecialchars($clasificacion['temporada']) . '</td>
                            <td>
                                <a href="edit_clasificacion.php?id=' . $clasificacion['id'] . '" class="btn btn-warning btn-sm">Editar</a>
                                <a href="add_clasificacion.php" class="btn btn-success btn-sm mx-2">Añadir</a>
                                <form action="delete_clasificacion.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="' . $clasificacion['id'] . '">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta clasificación?\')">Eliminar</button>
                                </form>
                            </td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">No se encontraron clasificaciones.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
