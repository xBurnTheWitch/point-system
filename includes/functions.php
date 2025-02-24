<?php

// Función para validar que un campo no esté vacío
function validateNotEmpty($value) {
    return !empty($value);
}

// Función para validar el formato de correo electrónico
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Función para verificar si la contraseña tiene una longitud mínima
function validatePasswordStrength($password) {
    return strlen($password) >= 8;  // La contraseña debe tener al menos 8 caracteres
}

// Función para verificar si las contraseñas coinciden
function checkPasswords($password1, $password2) {
    return $password1 === $password2;
}

// Función para verificar si el correo electrónico ya está registrado en la base de datos
function emailExists($email, $pdo) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetchColumn() > 0;
}

// Función para encriptar la contraseña antes de guardarla en la base de datos
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Función para verificar la contraseña en el proceso de inicio de sesión
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Función para generar un token de verificación (por ejemplo, para confirmar el registro)
function generateVerificationToken() {
    return bin2hex(random_bytes(16));  // Genera un token único de 32 caracteres
}

// Función para enviar un correo electrónico utilizando PHPMailer
function sendEmail($to, $subject, $body) {
    // Usando PHPMailer (asegúrate de haber incluido PHPMailer correctamente)
    require 'vendor/autoload.php';
    
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com';  // Configura tu servidor SMTP
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@example.com';  // Tu correo electrónico
    $mail->Password = 'your_email_password';  // Tu contraseña de correo
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('your_email@example.com', 'Nombre del Sistema');
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->Body = $body;

    if (!$mail->send()) {
        return 'Error al enviar el correo: ' . $mail->ErrorInfo;
    }
    return true;
}

?>
