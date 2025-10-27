<?php
require 'conexion.php';

$data = json_decode(file_get_contents('php://input'), true);

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO reservas (id_usuario, fecha, hora, category_key, sub_table, sub_id, subservicio_name, sena_pagada, status) VALUES (:user_id, :fecha, :hora, :cat_key, :sub_table, :sub_id, :sub_name, :sena, 'pendiente')");
    $stmt->execute([
        ':user_id' => $data['user_id'],
        ':fecha' => $data['date'],
        ':hora' => $data['time'],
        ':cat_key' => $data['category_key'],
        ':sub_table' => $data['sub_table'],
        ':sub_id' => $data['sub_id'],
        ':sub_name' => $data['subservicio_name'],
        ':sena' => $data['sena']
    ]);

    // Update horarios to 'no'
    $stmtUpdate = $pdo->prepare("UPDATE horarios SET disponible = 'no' WHERE fecha = :fecha AND hora = :hora");
    $stmtUpdate->execute([':fecha' => $data['date'], ':hora' => $data['time']]);

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}