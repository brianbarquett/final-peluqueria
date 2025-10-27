<?php
require 'conexion.php';

$days = 7;

$stmt = $pdo->query("SELECT * FROM config_atencion");
$configs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$generated = 0;
for ($d = 0; $d < $days; $d++) {
    $fecha = new DateTime();
    $fecha->add(new DateInterval('P' . $d . 'D'));
    $fecha_str = $fecha->format('Y-m-d');

    $weekday = strtolower($fecha->format('l'));
    $weekdays_map = ['monday' => 'lunes', 'tuesday' => 'martes', 'wednesday' => 'miercoles', 'thursday' => 'jueves', 'friday' => 'viernes', 'saturday' => 'sabado', 'sunday' => 'domingo'];
    $dia = $weekdays_map[$weekday] ?? '';

    if ($dia) {
        $config = array_filter($configs, fn($c) => $c['dia_semana'] === $dia);
        $config = reset($config);
        if ($config) {
            $manana_inicio = new DateTime($config['manana_inicio']);
            $manana_fin = new DateTime($config['manana_fin']);
            $tarde_inicio = new DateTime($config['tarde_inicio']);
            $tarde_fin = new DateTime($config['tarde_fin']);
            $intervalo = new DateInterval('PT' . $config['intervalo'] . 'M');

            // Mañana
            $current = clone $manana_inicio;
            while ($current < $manana_fin) {
                $hora = $current->format('H:i');
                if (insertHorario($pdo, $fecha_str, $hora)) $generated++;
                $current->add($intervalo);
            }

            // Tarde
            $current = clone $tarde_inicio;
            while ($current < $tarde_fin) {
                $hora = $current->format('H:i');
                if (insertHorario($pdo, $fecha_str, $hora)) $generated++;
                $current->add($intervalo);
            }
        }
    }
}
echo json_encode(['success' => true, 'message' => "Horarios generados: $generated"]);

function insertHorario($pdo, $fecha, $hora) {
    $stmt = $pdo->prepare("INSERT IGNORE INTO horarios (fecha, hora, disponible) VALUES (:fecha, :hora, 'si')");
    return $stmt->execute([':fecha' => $fecha, ':hora' => $hora . ':00']);  // Añadir :00 for full time
}