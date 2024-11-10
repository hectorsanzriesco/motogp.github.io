<?php
session_start();
include('conection.php');

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $nombre_piloto = $_POST['nombre_piloto'];
    $temporada = $_POST['temporada'];
    $puntos_totales_piloto = $_POST['puntos_totales_piloto'];
    $posicion_piloto = $_POST['posicion_piloto'];

    // Preparar la consulta SQL para insertar los datos
    $query = 'INSERT INTO clasificacion (nombre_piloto, temporada, puntos_totales_piloto, posicion_piloto) 
              VALUES (:nombre_piloto, :temporada, :puntos_totales_piloto, :posicion_piloto)';
    $stmt = $pdo->prepare($query);

    // Ejecutar la consulta
    $stmt->execute([
        ':nombre_piloto' => $nombre_piloto,
        ':temporada' => $temporada,
        ':puntos_totales_piloto' => $puntos_totales_piloto,
        ':posicion_piloto' => $posicion_piloto
    ]);

    // Guardar mensaje de éxito en la sesión
    $_SESSION['mensaje'] = 'Clasificación añadida correctamente.';
    // Redirigir al usuario a la página principal
    header('Location: clasification.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Clasificación - Moto GP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm p-1 mb-5 bg-body rounded sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index_admin.html">
                <img src="../../../img/Moto_Gp_logo.svg" alt="motogpLogo" width="90">
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="../piloto/pilotos.php">Pilotos</a></li>
                    <li class="nav-item"><a class="nav-link active" href="../equipos/equipos.php">Equipos</a></li>
                    <li class="nav-item"><a class="nav-link active" href="../circuitos/circuitos.html">Circuitos</a></li>
                    <li class="nav-item"><a class="nav-link active" href="../resultado_carrera/result_carrera.php">Resultados Carreras</a></li>
                    <li class="nav-item"><a class="nav-link disabled" href="">Clasificación</a></li>
                </ul>
            </div>
        </div>
        <p>Administrador</p>
    </nav>

    <div class="container">
        <h2 class="my-4">Añadir Nueva Clasificación</h2>

        <!-- Botón para volver atrás -->
        <button onclick="window.location.href='clasification.php';" class="btn btn-secondary mb-3">Volver a la Clasificación</button>

        <!-- Mostrar mensaje de éxito o error -->
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $_SESSION['mensaje']; ?>
                <?php unset($_SESSION['mensaje']); ?>
            </div>
        <?php endif; ?>

        <!-- Formulario para añadir clasificación -->
        <form action="add_clasification.php" method="POST">
            <div class="mb-3">
                <label for="nombre_piloto" class="form-label">Nombre del Piloto</label>
                <input type="text" class="form-control" id="nombre_piloto" name="nombre_piloto" required>
            </div>
            <div class="mb-3">
                <label for="temporada" class="form-label">Temporada</label>
                <input type="text" class="form-control" id="temporada" name="temporada" required>
            </div>
            <div class="mb-3">
                <label for="puntos_totales_piloto" class="form-label">Puntos Totales</label>
                <input type="number" class="form-control" id="puntos_totales_piloto" name="puntos_totales_piloto" required>
            </div>
            <div class="mb-3">
                <label for="posicion_piloto" class="form-label">Posición</label>
                <input type="number" class="form-control" id="posicion_piloto" name="posicion_piloto" required>
            </div>
            <button type="submit" class="btn btn-success">Añadir Clasificación</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
