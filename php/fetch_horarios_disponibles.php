<?php
require 'conexion.php';

$date = filter_input(INPUT_GET, 'date', FILTER_SANITIZE_STRING);

if ($date) {
    $stmt = $pdo->prepare("SELECT DATE_FORMAT(hora, '%H:%i') AS hora FROM horarios WHERE fecha = :date ORDER BY hora");
    $stmt->execute([':date' => $date]);
    $all = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (empty($all)) {
        // Auto generate for this date
        $weekday = strtolower(date('l', strtotime($date)));
        $weekdays_map = ['monday' => 'lunes', 'tuesday' => 'martes', 'wednesday' => 'miercoles', 'thursday' => 'jueves', 'friday' => 'viernes', 'saturday' => 'sabado', 'sunday' => 'domingo'];
        $dia = $weekdays_map[$weekday] ?? '';

        if ($dia) {
            $stmtConfig = $pdo->prepare("SELECT * FROM config_atencion WHERE dia_semana = :dia");
            $stmtConfig->execute([':dia' => $dia]);
            $config = $stmtConfig->fetch(PDO::FETCH_ASSOC);

            if ($config) {
                $manana_inicio = new DateTime($config['manana_inicio']);
                $manana_fin = new DateTime($config['manana_fin']);
                $tarde_inicio = new DateTime($config['tarde_inicio']);
                $tarde_fin = new DateTime($config['tarde_fin']);
                $intervalo = new DateInterval('PT' . $config['intervalo'] . 'M');

                // Mañana
                $current = clone $manana_inicio;
                while ($current < $manana_fin) {
                    $hora = $current->format('H:i:00');
                    insertHorario($pdo, $date, $hora);
                    $current->add($intervalo);
                }

                // Tarde
                $current = clone $tarde_inicio;
                while ($current < $tarde_fin) {
                    $hora = $current->format('H:i:00');
                    insertHorario($pdo, $date, $hora);
                    $current->add($intervalo);
                }
            }
            // Re-fetch after generate
            $stmt->execute([':date' => $date]);
            $all = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }
    }

    $disponibles = array_filter($all, function($hora) use ($pdo, $date) {
        $stmtCheck = $pdo->prepare("SELECT disponible FROM horarios WHERE fecha = :fecha AND hora = :hora");
        $stmtCheck->execute([':fecha' => $date, ':hora' => $hora . ':00']);
        return $stmtCheck->fetchColumn() === 'si';
    });

    echo json_encode(array_values($disponibles));
} else {
    echo json_encode([]);
}

function insertHorario($pdo, $fecha, $hora) {
    $stmt = $pdo->prepare("INSERT IGNORE INTO horarios (fecha, hora, disponible) VALUES (:fecha, :hora, 'si')");
    $stmt->execute([':fecha' => $fecha, ':hora' => $hora]);
}