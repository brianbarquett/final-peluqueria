<?php
require 'conexion.php';

$date = filter_input(INPUT_GET, 'date', FILTER_SANITIZE_STRING);

if ($date) {
    $stmt = $pdo->prepare("SELECT r.*, u.nombre AS user_name FROM reservas r JOIN usuarios u ON r.id_usuario = u.idusuario WHERE r.fecha = :date ORDER BY r.hora");
    $stmt->execute([':date' => $date]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    echo json_encode([]);
}