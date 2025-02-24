<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $puntos = $_POST['puntos'];
    $motivo = $_POST['motivo'];
    $asignado_por = $_POST['asignado_por'];

    try {
        $stmt = $pdo->prepare("INSERT INTO points_history (user_id, puntos, motivo, asignado_por) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $puntos, $motivo, $asignado_por]);
        echo "Puntos asignados correctamente.";
    } catch (PDOException $e) {
        echo "Error al asignar puntos: " . $e->getMessage();
    }
}
?>

<form method="POST" action="assign_points.php">
    ID del usuario: <input type="number" name="user_id" required><br>
    Puntos: <input type="number" name="puntos" required><br>
    Motivo: <textarea name="motivo" required></textarea><br>
    ID del supervisor: <input type="number" name="asignado_por" required><br>
    <input type="submit" value="Asignar puntos">
</form>
