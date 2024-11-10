<?php
session_start();  // Iniciar sesión

include('conexion.php');

// Obtener los datos de los circuitos (incluyendo el campo 'id')
$query = 'SELECT id, nombre, ubicacion, longitud_km, numero_curvas FROM circuitos';
$stmt = $pdo->query($query);
$circuitos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mostrar el mensaje si el circuito fue eliminado
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
    <title>Circuitos - Moto GP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <!-- Imagen de pestaña -->
    <link rel="shortcut icon" href="../../../img/Moto_Gp_logo.svg" />
    <!-- Estilos CSS CDN Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Scripts JS CDN Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- Estilos CSS Propios -->
    <link rel="stylesheet" href="../../../style/style.css">
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
                        <a class="nav-link disabled" href="./circuitos/circuito.html">Circuitos</a>
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
        <h2 class="my-4">Lista de Circuitos</h2>

        <!-- Botón para volver atrás -->
        <a href="../index_admin.html" class="btn btn-secondary mb-3">Volver Atrás</a>

        <!-- Mostrar mensaje de éxito o error -->
        <?php if ($mensaje): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <!-- Tabla de circuitos -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Ubicación</th>
                    <th scope="col">Longitud_km</th>
                    <th scope="col">Numero de Curvas</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($circuitos) {
                    foreach ($circuitos as $circuito) {
                        echo '
                        <tr>
                            <td>' . $circuito['nombre'] . '</td>
                            <td>' . $circuito['ubicacion'] . '</td>
                            <td>' . $circuito['longitud_km'] . ' km</td>
                            <td>' . $circuito['numero_curvas'] . '</td>
                            <td>
                                <!-- Botón para editar -->
                                <a href="edit_circuito.php?id=' . $circuito['id'] . '" class="btn btn-warning btn-sm">Editar</a>
                                <!-- Botón para añadir nuevo circuito -->
                                <a href="add_circuito.php" class="btn btn-success btn-sm mx-2">Añadir</a>
                                <!-- Formulario para eliminar -->
                                <form action="delete_circuito.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="' . $circuito['id'] . '">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este circuito?\')">Eliminar</button>
                                </form>
                            </td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">No se encontraron circuitos.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
