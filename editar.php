<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "abm"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// --- PARTE 1: PROCESAR LA ACTUALIZACIÓN ---
if (isset($_POST['actualizar'])) {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['contrasena']; // Recibimos la nueva contraseña

    // Añadimos contrasena='$contrasena' a la consulta SQL
    $sql = "UPDATE usuarios SET nombre='$nombre', email='$email', password='$password' WHERE id=$id";

    if ($conn->query($sql)) {
        header("Location: mostrar.php"); // Volver a la lista automáticamente
        exit();
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
}

// --- PARTE 2: CARGAR DATOS ACTUALES ---
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $resultado = $conn->query("SELECT * FROM usuarios WHERE id = $id");
    $usuario = $resultado->fetch_assoc();
    
    if (!$usuario) {
        die("Usuario no encontrado.");
    }
} else {
    die("ID no proporcionado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        form { max-width: 400px; }
        input { width: 100%; padding: 8px; margin: 10px 0; box-sizing: border-box; }
        button { background-color: #28a745; color: white; padding: 10px; border: none; width: 100%; cursor: pointer; }
        button:hover { background-color: #218838; }
        a { display: inline-block; margin-top: 10px; color: #dc3545; text-decoration: none; }
    </style>
</head>
<body>

    <h2>Editar Usuario</h2>
    <form method="POST" action="editar.php?id=<?php echo $id; ?>">
        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
        
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required>
        
        <label>Contraseña:</label>
        <input type="text" name="contrasena" value="<?php echo $usuario['password']; ?>" required>
        
        <button type="submit" name="actualizar">Guardar Cambios</button>
        <a href="mostrar.php">Cancelar y Volver</a>
    </form>

</body>
</html>

<?php $conn->close(); ?>
