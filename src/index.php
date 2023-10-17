<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calidad de la enseñanza</title>
</head>
<body>
    <h1><?php echo " Hola mundo";?></h1>
    <h1><?php
$servername = "some-mysql-db"; // Este es el nombre del contenedor de MySQL
$username = "root"; // Usuario por defecto para MySQL
$password = "root"; // Reemplaza con tu contraseña de root
$dbname = "calidad"; // Reemplaza con el nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}else{
    echo "lo has conseguido";
}
?>
</h1>
</body>
</html>

#1 Significado especial de localhost

