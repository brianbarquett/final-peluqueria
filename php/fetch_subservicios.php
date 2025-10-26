<?php
require 'conexion.php';

$category_key = filter_input(INPUT_GET, 'category_key', FILTER_SANITIZE_STRING);

if ($category_key) {
    $table = '';
    switch ($category_key) {
        case 'corte': $table = 'contenidos'; break;
        case 'tintura': $table = 'tintura'; break;
        case 'lavado': $table = 'lavado'; break;
        case 'barba': $table = 'barba'; break;
        case 'peinado': $table = 'peinado'; break;
        default: echo json_encode([]); exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM $table");
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    echo json_encode([]);
}