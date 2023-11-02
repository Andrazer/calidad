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

    // Verificar la conexión
    if ($conn->connect_error) {
        die('<p class="text-danger">(Conexión fallida)</p>' . $conn->connect_error);
    } else {
        echo '<p class="text-primary">(Conectado)</p>';
    }
  ?>

  <div class="container" id="formulario">
    <h1 class="text-primary">Formulario de Calidad de la enseñanza</h1>
    <?php
    $formularioVisible = true; // Variable para controlar la visibilidad del formulario

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $t_incidencia = $_POST["t_incidencia"];
        $t_usuario = $_POST["t_usuario"];
        $categoria = $_POST["categoria"];
        $unidad = $_POST["unidad"];
        $descripcion = $_POST["descripcion"];
    
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
    
            $insert_stmt->bind_param("ssssissss", $t_incidencia, $t_usuario, $categoria, $unidad, $descripcion, $respuesta, $email, $fecha, $hora);
    
            if ($insert_stmt->execute() === true) {
                $formularioVisible = false; // Ocultar el formulario después de enviar
                echo "
                <p>Datos insertados correctamente en la base de datos.</p>
                
                <a href='http://localhost:3000/'>
                  <button type='submit' class='btn btn-primary'>Volver</button>
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
      <div class="container d-flex">
        <div class="form-group col-4">
          <label for="t_incidencia">Tipo de Incidencia:</label>
            <select class="form-control" name="t_incidencia" id="t_incidencia">
              <option value="RECLAMACION">RECLAMACIÓN</option>
              <option value="SUGERENCIA">SUGERENCIA</option>
              <option value="QUEJA">QUEJA</option>
            </select>
        </div>
        <div class="form-group col-4">
          <label for="t_usuario">Tipo de Usuario:</label>
            <select class="form-control" name="t_usuario" id="t_usuario" required>
              <option value="PROFESOR">PROFESOR</option>
              <option value="ALUMNO">ALUMNO</option>
            </select>
        </div>
        <div class="form-group col-4">
            <label for="categoria">Categoría:</label>
            <input type="text" class="form-control" name="categoria" id="categoria" required>
        </div>
    </div>
    <div>
      <div class="form-group">
        <label for="unidad">Unidad:</label>
        <input type="text" class="form-control" name="unidad" id="unidad" required>
      </div>
      <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea class="form-control" name="descripcion" id="descripcion" rows="4" required></textarea>
      </div>
      <div class="form-group">
        <label for="respuesta">Respuesta:</label>
          <select class="form-control" name="respuesta" id="respuesta" required>
            <option value="0">No</option>
            <option value="1">Sí</option>
          </select>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" class="form-control" name="email" id="email">
      </div>
      <div class="container">
        <button type="submit" class="btn btn-primary">Enviar</button>
      </div>
    </div>
    </form>
    <div class="container">
      <a href='http://localhost:3000/vista_tabla.php'>
        <button type='submit' class='btn btn-primary'>Lista de sugerencias</button>
      </a>
    </div>
    <?php
    }
    ?>
</div>

  
  <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>