<?php
include 'db_connect.php';

try {
    $stmt = $pdo->query("SELECT * FROM rewards WHERE disponible = 1");
    $rewards = $stmt->fetchAll();

    echo "<h2>Recompensas disponibles:</h2>";
    foreach ($rewards as $reward) {
        echo "Nombre: " . $reward['nombre'] . "<br>";
        echo "Descripción: " . $reward['descripcion'] . "<br>";
        echo "Puntos necesarios: " . $reward['puntos_necesarios'] . "<br><hr>";
    }
} catch (PDOException $e) {
    echo "Error al obtener recompensas: " . $e->getMessage();
}
?>
