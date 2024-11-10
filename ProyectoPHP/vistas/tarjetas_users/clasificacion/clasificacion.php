<?php
// Iniciar la sesión (si es necesario)
session_start();

// Conectar a la base de datos
$servername = "localhost"; // Cambia esto según tu configuración
$username = "Hector"; // Cambia esto si es necesario
$password = "1234"; // Cambia esto si es necesario
$dbname = "motogp"; // Cambia esto por el nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar los datos de clasificación
$sql = "SELECT nombre_piloto, temporada, puntos_totales_piloto, posicion_piloto FROM clasificacion ORDER BY temporada DESC, posicion_piloto ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clasificación - Moto GP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <style>
        /* Centrar solo el título */
        h2 {
            text-align: center;
            margin-top: 50px;
            /* Añadir espacio en la parte superior */
        }

        /* Aseguramos que el botón "Volver" se vea igual que en el ejemplo proporcionado */
        .back-btn {
            display: block;
            margin: 20px auto;
            /* Centra el botón debajo de la tabla */
        }
    </style>
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
                        <a class="nav-link active" aria-current="page" href="../piloto/pilotos.php">Pilotos</a>
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
                        <a class="nav-link disabled" href="">Clasificacion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <!-- Título centrado -->
        <h2>Clasificación General</h2>

        <!-- Botón para volver atrás -->
        <button onclick="window.history.back()" class="btn btn-secondary mb-3">Volver Atrás</button>

        <!-- Tabla de clasificación -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Posición</th>
                    <th>Piloto</th>
                    <th>Puntos Totales</th>
                    <th>Temporada</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Mostrar los datos de la clasificación
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['posicion_piloto'] . "</td>";  // Mostrar la posición del piloto
                        echo "<td>" . $row['nombre_piloto'] . "</td>";    // Nombre del piloto
                        echo "<td>" . $row['puntos_totales_piloto'] . "</td>";  // Puntos totales del piloto
                        echo "<td>" . $row['temporada'] . "</td>";   // Temporada
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay datos disponibles</td></tr>";
                }

                // Cerrar la conexión
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>