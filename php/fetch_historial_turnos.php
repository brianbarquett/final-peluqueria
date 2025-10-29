<?php
require 'conexion.php';

$stmt = $pdo->query("SELECT r.*, u.nombre AS user_name FROM reservas r JOIN usuarios u ON r.id_usuario = u.idusuario WHERE r.status != 'pendiente' ORDER BY r.fecha DESC, r.hora DESC");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));