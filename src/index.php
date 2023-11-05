<?php
// inicio.php
include('header.php');
?>


  <?php

    $servername = "db"; // Este es el nombre del contenedor de MySQL
    $username = "root"; // Usuario por defecto para MySQL
    $password = "root"; // Reemplaza con tu contraseña de root
    $dbname = "mi_basededatos"; // Reemplaza con el nombre de tu base de datos

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
  /*
    // Verificar la conexión
    if ($conn->connect_error) {
        die('<p class="text-danger">(Conexión fallida)</p>' . $conn->connect_error);
    } else {
        echo '<p class="text-primary">(Conectado)</p>';
    }
  */
  ?>

  <div class="container rounded-4 shadow border border-3 border-secondary border-dotted p-3" id="formulario">
    <div class="container">
      <div class="container">
        <h1 class="text-secondary fw-bold">Formulario de Calidad de la enseñanza</h1>
      </div>
    </div>
    <?php
    $formularioVisible = true; // Variable para controlar la visibilidad del formulario

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $t_incidencia = $_POST["t_incidencia"];
        $t_usuario = $_POST["t_usuario"];
        $categoria = $_POST["categoria"];
        $unidad = $_POST["unidad"];
        //$descripcion = $_POST["descripcion"];

        $descripcion = mysqli_real_escape_string($conn, $_POST["descripcion"]);

        // Realizar una consulta para verificar si el registro ya existe
        $sql = "SELECT id FROM Calidad WHERE
                t_incidencia = ? AND
                t_usuario = ? AND
                categoria = ? AND
                unidad = ? AND
                descripcion = ?";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $t_incidencia, $t_usuario, $categoria, $unidad, $descripcion);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows == 0) {
            // No se encontró un registro existente, procede con la inserción
            $respuesta = $_POST["respuesta"];
            $email = $_POST["email"];
    
            $fecha = date("Y-m-d");
            $hora = date("H:i:s");
    
            $insert_sql = "INSERT INTO Calidad (t_incidencia, t_usuario, categoria, unidad, descripcion, respuesta, email, fecha, hora) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
            $insert_stmt = $conn->prepare($insert_sql);
    
            if ($insert_stmt === false) {
                die("Error en la preparación de la consulta de inserción: " . $conn->error);
            }
    
            $insert_stmt->bind_param("sssssssss", $t_incidencia, $t_usuario, $categoria, $unidad, $descripcion, $respuesta, $email, $fecha, $hora);
    
            if ($insert_stmt->execute() === true) {
                $formularioVisible = false; // Ocultar el formulario después de enviar
                echo "
                <p>Datos insertados correctamente en la base de datos.</p>
                
                <a href='http://localhost:3000/'>
                  <button type='submit' class='btn btn-light fw-bold position-relative top-50 start-50 translate-middle'>Volver</button>
                </a>
                ";
            } else {
                echo "Error al insertar datos en la base de datos: " . $insert_stmt->error;
            }
    
            $insert_stmt->close();
        } else {
            echo '<p class="text-danger">El registro ya existe en la base de datos.</p>';
        }
    
        $stmt->close();
    }

    if ($formularioVisible) {
        // Mostrar el formulario si la variable $formularioVisible es verdadera
    ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div class="container d-flex pt-3">
        <div class="container form-group col-3 fw-bold">
          <label for="t_incidencia">Tipo de Incidencia:</label>
            <select class="form-control mt-2 border border-secondary name="t_incidencia" id="t_incidencia">
              <option value="RECLAMACION">RECLAMACIÓN</option>
              <option value="SUGERENCIA">SUGERENCIA</option>
              <option value="QUEJA">QUEJA</option>
            </select>
        </div>
        <div class="container form-group col-3 fw-bold">
          <label for="t_usuario">Tipo de Usuario:</label>
            <select class="form-control mt-2 border border-secondary" name="t_usuario" id="t_usuario" required>
              <option value="PROFESOR">PROFESOR</option>
              <option value="ALUMNO">ALUMNO</option>
            </select>
        </div>
        <div class="container form-group col-3 fw-bold">
            <label for="categoria">Categoría:</label>
            <input type="text" class="form-control mt-2 border border-secondary" name="categoria" id="categoria" required>
        </div>

        <div class="container form-group col-3 fw-bold">
          <label for="unidad">Unidad:</label>
          <input type="text" class="form-control mt-2 border border-secondary" name="unidad" id="unidad" required>
        </div>
      </div>
      <div class="container">
        <div class="form-group fw-bold pt-3">
          <label for="descripcion">Descripción:</label>
          <textarea class="form-control mt-2 border border-secondary" name="descripcion" id="descripcion" rows="8" required></textarea>
        </div>
        <div class="container d-flex pt-3">
          <div class="container form-group col-3 fw-bold">
            <label for="respuesta">Respuesta:</label>
            <select class="form-control mt-2 border border-secondary" name="respuesta" id="respuesta" required>
              <option value="No">No</option>
              <option value="Si">Sí</option>
            </select>
          </div>

          <div class="container form-group col-6 fw-bold">
            <label for="email">Email:</label>
            <input type="text" class="form-control mt-2 border border-secondary" name="email" id="email">
          </div>

          <div class="container form-group col-3 fw-bold d-flex align-items-center">
          <button type="submit" class="btn btn-lg btn-outline-secondary fw-bold align-text-top mt-auto">Enviar</button>
          </div>
        </div></div>
    </div>
    </form>
  <?php
    }
  ?>
</div>

<div class="container">
  <div class="container">
    <a href='http://localhost:3000/vista_tabla.php'>
      <button type='submit' class='btn btn-light fw-bold position-absolute pt-5 top-0 start-20 translate-middle'>Lista de sugerencias</button>
    </a>
  </div>
</div>

<script>
document.getElementById("respuesta").addEventListener("change", function() {
  var emailField = document.getElementById("email");

  if (this.value === "Si") {
    emailField.required = true;
  } else {
    emailField.required = false;
  }
});

</script>

<?php
// inicio.php
include('footer.php');
?>



