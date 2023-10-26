<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        .fixed-table {
            max-height: 400px; /* Establece la altura máxima de la tabla */
            overflow-y: auto; /* Agrega la barra de desplazamiento vertical cuando sea necesario */
        }
    </style>
    <title>Registros de la Base de Datos</title>
</head>
<body>
    <?php
    // Tu código PHP para la conexión a la base de datos y consulta aquí
    $servername = "db"; // Este es el nombre del contenedor de MySQL
    $username = "root"; // Usuario por defecto para MySQL
    $password = "root"; // Reemplaza con tu contraseña de root
    $dbname = "mi_basededatos"; // Reemplaza con el nombre de tu base de datos

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    $select_sql = "SELECT * FROM Calidad";
    $result = $conn->query($select_sql);
    ?>

    <div class="container">
        <h1 class="text-primary">Registros de la Base de Datos</h1>
        <div class="fixed-table">
            <table class='table'>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Incidencia</th>
                    <th>Tipo de Usuario</th>
                    <th>Categoría</th>
                    <th>Unidad</th>
                    <th>Descripción</th>
                    <th>Respuesta</th>
                    <th>Email</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                </tr>
                <?php
                      // Tu código PHP para mostrar los registros de la base de datos aquí
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>{$row['id']}</td>";
                      echo "<td>{$row['t_incidencia']}</td>";
                      echo "<td>{$row['t_usuario']}</td>";
                      echo "<td>{$row['categoria']}</td>";
                      echo "<td>{$row['unidad']}</td>";
                      echo "<td>{$row['descripcion']}</td>";
                      echo "<td>{$row['respuesta']}</td>";
                      echo "<td>{$row['email']}</td>";
                      echo "<td>{$row['fecha']}</td>";
                      echo "<td>{$row['hora']}</td>";
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td colspan='10'>No hay registros en la base de datos.</td></tr>";
                  }
                ?>
            </table>
        </div>
    </div>

    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
