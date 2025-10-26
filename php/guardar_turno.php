<?php
require 'conexion.php';

$data = json_decode(file_get_contents('php://input'), true);

try {
    $stmt = $pdo->prepare("INSERT INTO reservas (id_usuario, fecha, hora, category_key, sub_table, sub_id, sena_pagada, status) VALUES (:user_id, :fecha, :hora, :cat_key, :sub_table, :sub_id, :sena, 'pendiente')");
    $stmt->execute([
        ':user_id' => $data['user_id'],
        ':fecha' => $data['date'],
        ':hora' => $data['time'],
        ':cat_key' => $data['category_key'],
        ':sub_table' => $data['sub_table'],
        ':sub_id' => $data['sub_id'],
        ':sena' => $data['sena']
    ]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}