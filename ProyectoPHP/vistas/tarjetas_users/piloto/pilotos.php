<?php
session_start();  // Iniciar sesión

// Establecer la conexión a la base de datos
$servername = "localhost";  
$username = "Hector";         
$password = "1234";             
$dbname = "motogp";         

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos de los pilotos, incluyendo el nombre del equipo
$sql = "SELECT p.nombre, p.fecha_nacimiento, p.nacionalidad, e.nombre as nombre_equipo 
        FROM pilotos AS p 
        INNER JOIN equipos AS e ON p.id_equipo = e.id"; 
$result = $conn->query($sql);

// Mostrar el mensaje si existe en la sesión
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
    <!-- Style CSS CDN BootStrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Style JS CDN BootStrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- Style CSS Propio -->
     <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <!-- NavBar -->
    <nav class="navbar navbar-expand-lg shadow-sm p-1 mb-5 bg-body rounded sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand disabled" href="../../index_users.html"><img src="../../../img/Moto_Gp_logo.svg" alt="motoLogo" width="90"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-current="page" href="./tarjetas_users/piloto/pilotos.php">Pilotos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../equipos/equipos.php">Equipos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../circuitos/circuitos.html">Circuitos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../resultado_carrera/result_carrera.php">Resultados Carreras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="../clasificacion/clasificacion.php">Clasificacion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Título centrado -->
        <h2 class="my-4 text-center">Lista de Pilotos</h2>

        <!-- Botón para volver atrás -->
        <button onclick="window.history.back()" class="btn btn-secondary mb-3">Volver Atrás</button>

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
                    <th scope="col">Fecha de Nacimiento</th>
                    <th scope="col">Nombre del Equipo</th> <!-- Nueva columna para el nombre del equipo -->
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($piloto = $result->fetch_assoc()) {
                        echo '
                        <tr>
                            <td>' . htmlspecialchars($piloto['nombre']) . '</td>
                            <td>' . htmlspecialchars($piloto['nacionalidad']) . '</td>
                            <td>' . htmlspecialchars($piloto['fecha_nacimiento']) . '</td>
                            <td>' . htmlspecialchars($piloto['nombre_equipo']) . '</td> <!-- Mostrar nombre del equipo -->
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="4">No se encontraron pilotos.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
<?php
// Cerrar la conexión
$conn->close();
?>
