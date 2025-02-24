<?php
// Incluir los archivos de conexión y funciones necesarias
include('../includes/db_connection.php');  // Conexión a la base de datos
include('../includes/functions.php');      // Funciones generales

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validar campos
    if (!validateNotEmpty($nombre) || !validateNotEmpty($email) || !validateNotEmpty($password)) {
        $error = "Todos los campos son obligatorios.";
    } elseif (!validateEmail($email)) {
        $error = "El correo electrónico no es válido.";
    } elseif (!validatePasswordStrength($password)) {
        $error = "La contraseña debe tener al menos 8 caracteres.";
    } elseif (!checkPasswords($password, $confirm_password)) {
        $error = "Las contraseñas no coinciden.";
    } elseif (emailExists($email, $pdo)) {
        $error = "El correo electrónico ya está registrado.";
    } else {
        // Si todo es válido, insertamos los datos del usuario en la base de datos
        $hashed_password = hashPassword($password);

        try {
            // Insertar nuevo usuario (por defecto, rol 'empleado')
            $stmt = $pdo->prepare("INSERT INTO users (nombre, email, contraseña) VALUES (?, ?, ?)");
            $stmt->execute([$nombre, $email, $hashed_password]);
            
            // Enviar correo al supervisor (si es necesario)
            // Aquí puedes implementar el envío del correo con el token de verificación

            $success = "¡Registro exitoso! Ahora se notificará al supervisor.";
        } catch (PDOException $e) {
            $error = "Error al registrar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empleado</title>
</head>
<body>
    <h2>Formulario de Registro</h2>

    <!-- Mostrar mensajes de error o éxito -->
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Formulario de registro -->
    <form metho
