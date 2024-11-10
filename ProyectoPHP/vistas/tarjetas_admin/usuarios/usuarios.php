<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <!-- Imagen de pestaña -->
    <link rel="shortcut icon" href="../../../img/Moto_Gp_logo.svg" />
    <link rel="stylesheet" href="../../style/style.css">
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

    <div class="container mt-4">
        <h3>Lista de Usuarios</h3>

        <?php
        // Mostrar el mensaje si está presente en la URL
        if (isset($_GET['mensaje'])) {
            echo '<div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                ' . htmlspecialchars($_GET['mensaje']) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        }
        ?>

        <div class="mb-3">
            <a href="agregar_usuario.php" class="btn btn-success">Añadir Usuario</a>
        </div>

        <?php
        // Conexión a la base de datos
        $servername = "localhost";
        $username = "Hector";
        $password = "1234";
        $dbname = "motogp";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta para obtener los usuarios
        $sql = "SELECT nombre_usuario, rol, fecha_registro, id FROM usuarios";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table table-bordered table-striped">';
            echo '<thead><tr><th>Nombre de Usuario</th><th>Rol</th><th>Fecha de Registro</th><th>Acciones</th></tr></thead><tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row["nombre_usuario"] . '</td>';
                echo '<td>' . $row["rol"] . '</td>';
                echo '<td>' . $row["fecha_registro"] . '</td>';
                echo '<td>
                    <a href="editar_usuario.php?id=' . $row["id"] . '" class="btn btn-warning btn-sm">Editar</a>
                    <a href="agregar_usuario.php?id=' . $row["id"] . '" class="btn btn-success btn-sm">Añadir</a> <!-- Botón Añadir Usuario -->
                    <form action="eliminar_usuario.php" method="POST" style="display:inline-block;">
                        <input type="hidden" name="id" value="' . $row["id"] . '">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de eliminar este usuario?\')">Eliminar</button>
                    </form>
                </td>';
                echo '</tr>';
            }

            echo '</tbody></table>';
        } else {
            echo "<p>No se encontraron usuarios.</p>";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </div>

    <script>
        // Agregar evento para que la alerta desaparezca al hacer clic en la "X"
        document.addEventListener("DOMContentLoaded", function() {
            var alertNode = document.getElementById("success-alert");
            if (alertNode) {
                alertNode.addEventListener("closed.bs.alert", function() {
                    // Remover el mensaje de la URL para que no aparezca al recargar la página
                    if (history.replaceState) {
                        history.replaceState(null, null, window.location.pathname);
                    }
                });
            }
        });
    </script>

</body>
</html>
