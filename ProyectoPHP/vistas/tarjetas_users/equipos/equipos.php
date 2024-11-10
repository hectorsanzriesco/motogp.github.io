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

// Obtener los datos de los equipos (nombre, pais, tecnico_principal)
$sql = "SELECT nombre, pais, tecnico_principal FROM equipos"; 
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
    <title>Equipos - Moto GP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <!-- Imagen de pestaña -->
    <link rel="shortcut icon" href="../../../img/Moto_Gp_logo.svg" />
    <!-- Style CSS Propio -->
    <link rel="stylesheet" href="../../../style/style.css">
</head>

<body>
    <!-- NavBar -->
    <nav class="navbar navbar-expand-lg shadow-sm p-1 mb-5 bg-body rounded sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand disabled" href="../../index_users.html">
                <img src="../../../img/Moto_Gp_logo.svg" alt="motoLogo" width="90">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../piloto/pilotos.php">Pilotos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="./tarjetas_users/equipos/equipos.php">Equipos</a>
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
        <h2 class="my-4 text-center">Lista de Equipos</h2>

        <!-- Botón para volver atrás -->
        <button onclick="window.history.back()" class="btn btn-secondary mb-3">Volver Atrás</button>

        <!-- Mostrar mensaje de éxito o error -->
        <?php if ($mensaje): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <!-- Tabla de equipos -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">País</th> <!-- Columna para el país -->
                    <th scope="col">Técnico Principal</th> <!-- Columna para el técnico principal -->
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($equipo = $result->fetch_assoc()) {
                        echo '<tr>
                                <td>' . htmlspecialchars($equipo['nombre']) . '</td>
                                <td>' . htmlspecialchars($equipo['pais']) . '</td>
                                <td>' . htmlspecialchars($equipo['tecnico_principal']) . '</td>
                            </tr>';
                    }
                } else {
                    echo '<tr><td colspan="3">No se encontraron equipos.</td></tr>';
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
