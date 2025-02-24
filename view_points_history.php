<?php
include 'db_connect.php';

$user_id = $_GET['user_id'];  // Obtener el ID del usuario desde la URL

try {
    $stmt = $pdo->prepare("SELECT * FROM points_history WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $points_history = $stmt->fetchAll();

    foreach ($points_history as $entry) {
        echo "Motivo: " . $entry['motivo'] . "<br>";
        echo "Puntos: " . $entry['puntos'] . "<br>";
        echo "Fecha: " . $entry['fecha'] . "<br><hr>";
    }
} catch (PDOException $e) {
    echo "Error al obtener historial: " . $e->getMessage();
}
?>

<form method="GET" action="view_points_history.php">
    ID del usuario: <input type="number" name="user_id" required><br>
    <input type="submit" value="Ver historial de puntos">
</form>
