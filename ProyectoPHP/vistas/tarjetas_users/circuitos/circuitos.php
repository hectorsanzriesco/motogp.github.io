<?php
include('../../../db.php');  // Asegúrate de que la ruta de la base de datos es correcta

// Consulta SQL para obtener los circuitos, sin la columna 'pais'
$sql = "SELECT nombre, longitud_km, ubicacion, numero_curvas FROM circuitos";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Iniciar tabla HTML
    echo "<div class='container'>";
    echo "<button onclick='window.history.back()' class='btn btn-secondary mb-3'>Volver Atrás</button>";  // Botón para volver atrás
    echo "<table class='table table-striped'>";
    echo "<thead>
            <tr>
                <th>Nombre</th>
                <th>Ubicacion</th>
                <th>Longitud</th>
                <th>Numero de Curvas</th>
            </tr>
          </thead>
          <tbody>";

    // Mostrar los datos de cada fila
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["ubicacion"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["longitud_km"]) . ' km'  . "</td>";
        echo "<td>" . htmlspecialchars($row["numero_curvas"]) . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
    echo "</div>";
} else {
    echo "No se encontraron resultados.";
}

// Cerrar la conexión
$conn->close();
?>
