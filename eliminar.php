<?php
// 1. Conexión a la base de datos
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "abm"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

/**
 * LÓGICA DE ELIMINACIÓN
 * Verificamos si el ID llega por GET (desde un enlace) o por POST (desde un formulario)
 */
if (isset($_REQUEST['id'])) {
    // Limpiamos el ID para asegurar que sea un número entero
    $id = intval($_REQUEST['id']); 

    // Sentencia SQL para borrar
    $sql = "DELETE FROM usuarios WHERE id = $id";

    if ($conn->query($sql)) {
        // ACCIÓN: Si se borra con éxito, volvemos a la lista (mostrar.php)
        header("Location: mostrar.php?mensaje=eliminado");
        exit();
    } else {
        echo "Error al intentar eliminar el registro: " . $conn->error;
    }
} else {
    echo "No se proporcionó un ID válido para eliminar.";
}

$conn->close();
?>
