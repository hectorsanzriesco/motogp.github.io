<?php
session_start();  // Iniciar sesión

include('conection.php');

// Obtener los datos de los resultados de las carreras
$query = 'SELECT id, nombre_carrera, nombre_piloto, posicion, tiempo, puntos FROM resultados_carreras';
$stmt = $pdo->query($query);
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

$mensaje = '';
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Carreras - Moto GP</title>
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
                        <a class="nav-link active" aria-current="page" href="../piloto/pilotos.php">Pilotos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../equipos/equipos.php">Equipos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../circuitos/index.php">Circuitos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="./">Resultados Carreras</a>
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
        <h2 class="my-4">Resultados de las Carreras</h2>
        <button onclick="window.location.href='../index_admin.html';" class="btn btn-secondary mb-3">Volver Atrás</button>

        <?php if ($mensaje): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Carrera</th>
                    <th scope="col">Piloto</th>
                    <th scope="col">Posición</th>
                    <th scope="col">Tiempo</th>
                    <th scope="col">Puntos</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultados) {
                    foreach ($resultados as $resultado) {
                        echo '
                        <tr>
                            <td>' . htmlspecialchars($resultado['nombre_carrera']) . '</td>
                            <td>' . htmlspecialchars($resultado['nombre_piloto']) . '</td>
                            <td>' . htmlspecialchars($resultado['posicion']) . '</td>
                            <td>' . htmlspecialchars($resultado['tiempo']) . '</td>
                            <td>' . htmlspecialchars($resultado['puntos']) . '</td>
                            <td>
                                <!-- Botón de Editar -->
                                <a href="edit_resultados.php?id=' . $resultado['id'] . '" class="btn btn-warning btn-sm">Editar</a>
                                <!-- Botón Añadir Nuevo Resultado entre editar y eliminar -->
                                <a href="add_resultados.php" class="btn btn-success btn-sm mx-2">Añadir</a>
                                <!-- Formulario de eliminar -->
                                <form action="delete_resultado.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="' . $resultado['id'] . '">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este resultado?\')">Eliminar</button>
                                </form>
                            </td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No se encontraron resultados.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>