<?php
require 'conexion.php';

$date = filter_input(INPUT_GET, 'date', FILTER_SANITIZE_STRING);

if ($date) {
    $stmt = $pdo->prepare("SELECT DATE_FORMAT(hora, '%H:%i') AS hora FROM horarios WHERE fecha = :date AND disponible = 'si' ORDER BY hora");
    $stmt->execute([':date' => $date]);
    $disponibles = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($disponibles);
} else {
    echo json_encode([]);
}