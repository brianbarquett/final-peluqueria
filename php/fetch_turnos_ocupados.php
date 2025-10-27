<?php
require 'conexion.php';

$date = filter_input(INPUT_GET, 'date', FILTER_SANITIZE_STRING);

if ($date) {
    $stmt = $pdo->prepare("SELECT TRIM(hora) AS hora FROM reservas WHERE fecha = :date");  // Trim para remover espacios/extra
    $stmt->execute([':date' => $date]);
    $ocupados = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($ocupados);
} else {
    echo json_encode([]);
}