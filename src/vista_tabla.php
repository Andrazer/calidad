<?php
// inicio.php
include('header.php');
?>

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

<div class="container rounded-4 shadow border border-3 border-secondary border-dotted p-3">
    <h1 class="text-secondary fw-bold">Registros de la Base de Datos</h1>
    <div class="table-responsive border border-secondary" style="max-height: 50vh;">
        <table class="table table-striped table-hover table-responsive" id="miTabla">
            <tr style="position: sticky; top: 0; background-color: #fff;">
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
                    echo "<td style='max-height: 100px; overflow-y: auto;'>{$row['descripcion']}</td>";
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
    <div class="container p-1 form-group fw-bold d-flex">
      <!--<div class="container">-->
          <a href='http://localhost:3000/'>
              <button type='submit' class='btn btn-outline-secondary fw-bold m-1'>Volver</button>
          </a>
      <!--</div>-->
      <!--<div class="container form-group col-3 fw-bold d-flex align-items-center justify-content-end">-->
          <button class="btn btn-outline-success fw-bold m-1" id="exportButton">CSV</button>
      <!--</div>-->
    </div>
</div>

<script>
function exportToExcel() {
  var table = document.getElementById("miTabla");
  var rows = table.rows;

  var data = [];
  for (var i = 0; i < rows.length; i++) {
    var row = [];
    for (var j = 0; j < rows[i].cells.length; j++) {
      row.push(rows[i].cells[j].textContent);
    }
    data.push(row);
  }

  var csvContent = "data:text/csv;charset=utf-8,";
  data.forEach(function (rowArray) {
    var row = rowArray.join(",");
    csvContent += row + "\r\n";
  });

  var encodedUri = encodeURI(csvContent);
  var link = document.createElement("a");
  link.setAttribute("href", encodedUri);
  link.setAttribute("download", "tabla.csv");
  link.style.display = "none";
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("exportButton").addEventListener("click", function() {
    exportToExcel();
  });
});
</script>

<?php
include('footer.php');
?>