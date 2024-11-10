<?php
session_start();
include('conection.php');

// Variables para los errores y mensaje de éxito
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $nombre_carrera = $_POST['nombre_carrera'];
    $nombre_piloto = $_POST['nombre_piloto'];
    $posicion = $_POST['posicion'];
    $tiempo = $_POST['tiempo'];
    $puntos = $_POST['puntos'];

    // Validar los datos (puedes agregar más validaciones si es necesario)
    if (empty($nombre_carrera) || empty($nombre_piloto) || empty($posicion) || empty($tiempo) || empty($puntos)) {
        $mensaje = 'Todos los campos son obligatorios.';
    } else {
        // Preparar la consulta para insertar el nuevo resultado
        $query = 'INSERT INTO resultados_carreras (nombre_carrera, nombre_piloto, posicion, tiempo, puntos) 
                  VALUES (:nombre_carrera, :nombre_piloto, :posicion, :tiempo, :puntos)';
        $stmt = $pdo->prepare($query);

        // Ejecutar la consulta
        $stmt->execute([
            ':nombre_carrera' => $nombre_carrera,
            ':nombre_piloto' => $nombre_piloto,
            ':posicion' => $posicion,
            ':tiempo' => $tiempo,
            ':puntos' => $puntos
        ]);

        // Mensaje de éxito
        $_SESSION['mensaje'] = 'Resultado añadido correctamente.';
        header('Location: resultados.php'); // Redirigir a la lista de resultados
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Resultado - Moto GP</title>
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
                        <a class="nav-link active" href="../piloto/pilotos.php">Pilotos</a>
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
    </nav>

    <div class="container">
        <h2 class="my-4">Añadir Resultado de Carrera</h2>
        <button onclick="window.location.href='resultados.php';" class="btn btn-secondary mb-3">Volver Atrás</button>

        <?php if ($mensaje): ?>
            <div class="alert alert-warning" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form action="add_resultados.php" method="POST">
            <div class="mb-3">
                <label for="nombre_carrera" class="form-label">Nombre de la Carrera</label>
                <input type="text" class="form-control" id="nombre_carrera" name="nombre_carrera" required>
            </div>
            <div class="mb-3">
                <label for="nombre_piloto" class="form-label">Nombre del Piloto</label>
                <input type="text" class="form-control" id="nombre_piloto" name="nombre_piloto" required>
            </div>
            <div class="mb-3">
                <label for="posicion" class="form-label">Posición</label>
                <input type="number" class="form-control" id="posicion" name="posicion" required>
            </div>
            <div class="mb-3">
                <label for="tiempo" class="form-label">Tiempo</label>
                <input type="text" class="form-control" id="tiempo" name="tiempo" required>
            </div>
            <div class="mb-3">
                <label for="puntos" class="form-label">Puntos</label>
                <input type="number" class="form-control" id="puntos" name="puntos" required>
            </div>
            <button type="submit" class="btn btn-success">Añadir Resultado</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
