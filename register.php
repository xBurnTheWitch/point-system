<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);


    try {
        $stmt = $pdo->prepare("INSERT INTO users (nombre, email, contraseña) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $email, $contraseña]);
        echo "Usuario registrado correctamente.";
    } catch (PDOException $e) {
        echo "Error al registrar usuario: " . $e->getMessage();
    }
}
?>

<form method="POST" action="register.php">
    Nombre: <input type="text" name="nombre" required><br>
    Correo electrónico: <input type="email" name="email" required><br>
    Contraseña: <input type="password" name="contraseña" required><br>
    <input type="submit" value="Registrar">
</form>
