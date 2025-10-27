<?php
require 'conexion.php';

$date = filter_input(INPUT_GET, 'date', FILTER_SANITIZE_STRING);

if ($date) {
    $weekday = strtolower(date('l', strtotime($date)));
    $weekdays_map = ['monday' => 'lunes', 'tuesday' => 'martes', 'wednesday' => 'miercoles', 'thursday' => 'jueves', 'friday' => 'viernes', 'saturday' => 'sabado', 'sunday' => 'domingo'];
    $dia = $weekdays_map[$weekday] ?? '';

    if ($dia) {
        $stmt = $pdo->prepare("SELECT * FROM config_atencion WHERE dia_semana = :dia");
        $stmt->execute([':dia' => $dia]);
        $config = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($config ? $config : ['error' => 'No config for day']);
    } else {
        echo json_encode(['error' => 'Invalid day']);
    }
} else {
    echo json_encode(['error' => 'No date']);
}