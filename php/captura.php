<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Exitoso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
        }
        h3 {
            color: #4CAF50;
            margin-bottom: 10px;
        }
        p {
            color: #333;
            margin-bottom: 20px;
        }
        .error h3 {
            color: #f44336;
        }
        button {
            background-color: #008CBA;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #007B9A;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        ini_set('display_errors', 1); // Para depuración (quítalo en producción)
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        require __DIR__ . '/../vendor/autoload.php';
        require __DIR__ . '/../php/conexion.php';

        MercadoPago\SDK::setAccessToken('APP_USR-2122609768538338-110110-699cf51ac71548b571a1d3f298b66992-283482986');

        // Logging para depuración (crea capturar_log.txt con permisos 777)
        $log_file = __DIR__ . '/capturar_log.txt';
        file_put_contents($log_file, date('Y-m-d H:i:s') . " - Capturar llamado: " . json_encode($_GET) . PHP_EOL, FILE_APPEND);

        $payment_id = $_GET['payment_id'] ?? null;
        $status = $_GET['status'] ?? null;

        if ($status === 'approved' && $payment_id) {
            // Verificar pago con SDK para seguridad
            $payment = MercadoPago\Payment::find_by_id($payment_id);
            file_put_contents($log_file, date('Y-m-d H:i:s') . " - Payment: " . json_encode($payment) . PHP_EOL, FILE_APPEND);

            if ($payment && $payment->status === 'approved') {
                // Parsear external_reference (ignoramos $sub_table ya que no se usa más)
                $external_parts = explode('|', $payment->external_reference);
                if (count($external_parts) !== 8) {
                    file_put_contents($log_file, date('Y-m-d H:i:s') . " - Error: External reference inválido" . PHP_EOL, FILE_APPEND);
                    echo '<div class="error"><h3>Error en los datos del pago</h3></div>';
                    echo "<p>Por favor, contacta soporte.</p>";
                } else {
                    list($user_id, $fecha, $hora, $category_key, $sub_table, $sub_id, $subservicio_name, $sena) = $external_parts;

                    // Verificar si horario aún disponible (para evitar duplicados)
                    $stmtCheck = $pdo->prepare("SELECT disponible FROM horarios WHERE fecha = :fecha AND hora = :hora");
                    $stmtCheck->execute([':fecha' => $fecha, ':hora' => $hora]);
                    $disponible = $stmtCheck->fetchColumn();

                    if ($disponible === 'si') {
                        // Insertar reserva con status 'confirmado', sena_pagada = monto pagado real, y met_pago = método de pago
                        $sena_pagada = $payment->transaction_amount;
                        $met_pago = $payment->payment_type_id ?? 'unknown'; // Usar payment_type_id; fallback a 'unknown' si es NULL (quítalo si la columna permite NULL)
                        file_put_contents($log_file, date('Y-m-d H:i:s') . " - Método de pago: " . $met_pago . PHP_EOL, FILE_APPEND);

                        $stmtInsert = $pdo->prepare("
                            INSERT INTO reservas 
                            (id_usuario, fecha, hora, category_key, met_pago, sub_id, subservicio_name, sena_pagada, status, payment_id) 
                            VALUES 
                            (:user_id, :fecha, :hora, :category_key, :met_pago, :sub_id, :subservicio_name, :sena_pagada, 'pendiente', :payment_id)
                        ");
                        $stmtInsert->execute([
                            ':user_id' => $user_id,
                            ':fecha' => $fecha,
                            ':hora' => $hora,
                            ':category_key' => $category_key,
                            ':met_pago' => $met_pago,
                            ':sub_id' => $sub_id,
                            ':subservicio_name' => $subservicio_name,
                            ':sena_pagada' => $sena_pagada,
                            ':payment_id' => $payment_id
                        ]);

                        // Marcar horario como no disponible
                        $stmtUpdateHorario = $pdo->prepare("UPDATE horarios SET disponible = 'no' WHERE fecha = :fecha AND hora = :hora");
                        $stmtUpdateHorario->execute([':fecha' => $fecha, ':hora' => $hora]);

                        file_put_contents($log_file, date('Y-m-d H:i:s') . " - Reserva insertada exitosamente para ID pago: $payment_id" . PHP_EOL, FILE_APPEND);

                        echo "<h3>Pago realizado con éxito</h3>";
                        echo "<p>Tu turno ha sido reservado correctamente. Monto de seña pagada: $sena_pagada ARS.</p>";
                    } else {
                        file_put_contents($log_file, date('Y-m-d H:i:s') . " - Horario ya no disponible para ID pago: $payment_id" . PHP_EOL, FILE_APPEND);
                        echo '<div class="error"><h3>Horario no disponible</h3></div>';
                        echo "<p>El horario ya fue tomado. Intenta con otro.</p>";
                    }
                }
            } else {
                echo '<div class="error"><h3>Error al verificar el pago</h3></div>';
                echo "<p>Por favor, contacta soporte.</p>";
            }
        } else {
            echo '<div class="error"><h3>Pago no aprobado</h3></div>';
            echo "<p>Intenta nuevamente o contacta soporte.</p>";
        }
        ?>
        <button onclick="window.location.href='https://peluqueriagold.free.nf/php/mis_turnos.php'">Volver al inicio</button>
    </div>
</body>
</html>