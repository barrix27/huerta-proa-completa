<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$mensaje_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "abm";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $email = trim($_POST['email']);
    $password = trim($_POST['contrasena']); // Tomamos la contraseña del formulario

    // Buscamos al usuario por su email y contraseña
    $sql = "SELECT id FROM usuarios WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Credenciales correctas
        $stmt->close();
        $conn->close();
        header("Location: huerta.html");
        exit();
    } else {
        // Credenciales incorrectas
        $mensaje_error = "Email o contraseña incorrectos. Inténtalo de nuevo.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema ABM - Iniciar Sesión</title>
    <style>
        body { font-family: sans-serif; margin: 40px; line-height: 1.6; background-color: #f4f4f9; }
        .container { max-width: 400px; margin: auto; border: 1px solid #ccc; padding: 20px; border-radius: 8px; background: #fff; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 8px; margin: 10px 0; box-sizing: border-box; }
        button { background-color: #007bff; color: white; padding: 10px; border: none; width: 100%; cursor: pointer; font-size: 16px; border-radius: 4px; }
        button:hover { background-color: #0056b3; }
        .error { color: red; font-weight: bold; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>

    <div class="container">
        <h2 style="text-align: center;">Iniciar Sesión</h2>
        
        <?php if (!empty($mensaje_error)): ?>
            <div class="error"><?php echo $mensaje_error; ?></div>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <label>Email:</label>
            <input type="email" name="email" required placeholder="juan@ejemplo.com">
            
            <label>Contraseña:</label>
            <input type="password" name="contrasena" required placeholder="********">
            
            <button type="submit">Entrar al Sistema</button>
        </form>
    </div>

</body>
</html>
