<?php
// Si ya existe una sesión o el usuario está registrado, lo redirigimos a la página principal.
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Incluir conexión a la base de datos
include('db_connection.php');

// Incluye el autoloader de Composer
require 'vendor/autoload.php';

// Variables de error
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($password) || empty($password_confirm)) {
        $error_message = "Todos los campos son obligatorios.";
    } elseif ($password !== $password_confirm) {
        $error_message = "Las contraseñas no coinciden.";
    } else {
        // Verificar si el email ya existe en la base de datos
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $error_message = "Este correo electrónico ya está registrado.";
        } else {
            // Hash de la contraseña para mayor seguridad
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Registrar el nuevo usuario en la base de datos (con rol 'empleado' por defecto)
            $query = "INSERT INTO users (nombre, email, contraseña, rol, confirmado) VALUES (?, ?, ?, 'empleado', 0)";
            $stmt = $pdo->prepare($query);
            if ($stmt->execute([$nombre, $email, $password_hash])) {
                // Enviar correo al supervisor para confirmar el registro
                // Aquí puedes hacer que el supervisor reciba el correo para confirmarlo

                $error_message = "Registro exitoso. Se ha enviado un correo al supervisor para confirmar tu cuenta.";
            } else {
                $error_message = "Error al registrar el usuario. Intenta nuevamente.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
</head>
<body>
    <h1>Registro de Nuevo Usuario</h1>

    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="register.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required><br>

        <label for="password_confirm">Confirmar Contraseña:</label>
        <input type="password" name="password_confirm" id="password_confirm" required><br>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>
