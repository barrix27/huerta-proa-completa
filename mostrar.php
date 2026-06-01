<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "abm";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Añadimos contrasena al SELECT
$sql = "SELECT id, nombre, email, password FROM usuarios";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .btn-volver { display: inline-block; margin-bottom: 15px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <h2>Usuarios Registrados (Panel de Administración)</h2>
    <a href="huerta.html" class="btn-volver">← Volver a la Tienda (Huerta)</a>

    <?php
    if ($resultado->num_rows > 0) {
        echo "<table>";
        // Añadimos la cabecera de Contraseña
        echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>password</th><th>Acciones</th></tr>";

        while($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $fila["id"] . "</td>";
            echo "<td>" . $fila["nombre"] . "</td>";
            echo "<td>" . $fila["email"] . "</td>";
            echo "<td><code>" . $fila["password"] . "</code></td>"; // Se muestra la contraseña actual
            echo "<td>
                    <a href='editar.php?id=" . $fila["id"] . "'>Editar</a> | 
                    <a href='eliminar.php?id=" . $fila["id"] . "' style='color:red;'>Eliminar</a>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>0 resultados encontrados.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
