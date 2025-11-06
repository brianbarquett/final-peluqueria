<?php
// webhook_mercadopago.php
// Este script recibe notificaciones (webhooks) de Mercado Pago.
// Actualiza el status de la reserva y marca el horario como no disponible solo si el pago es 'approved'.
// Asegúrate de que esta URL sea accesible públicamente (no localhost en producción).
// Para testing, usa herramientas como ngrok para exponer localhost.

require __DIR__ . '/../vendor/autoload.php'; // Ajusta la ruta
require __DIR__ . '/../php/conexion.php'; // Ajusta la ruta

MercadoPago\SDK::setAccessToken('APP_USR-1969609096585871-110110-c92e7e04539d841305e3b9b96f45732b-2959473413'); // Tu access token

// Obtener datos del webhook (Mercado Pago envía POST con topic y id)
$topic = $_GET['topic'] ?? null;
$id = $_GET['id'] ?? null;

if ($topic === 'payment' && $id) {
    // Obtener detalles del pago
    $payment = MercadoPago\Payment::find_by_id($id);
    
    if ($payment && $payment->status === 'approved') {
        // Pago aprobado: Obtener el external_reference (ID de reserva)
        $reserva_id = $payment->external_reference;
        
        // Obtener detalles de la reserva para actualizar el horario
        $stmtReserva = $pdo->prepare("SELECT fecha, hora, sena_pagada FROM reservas WHERE id = :id");
        $stmtReserva->execute([':id' => $reserva_id]);
        $reserva = $stmtReserva->fetch(PDO::FETCH_ASSOC);
        
        if ($reserva) {
            // Actualizar reserva: status a 'confirmado' y sena_pagada al monto pagado
            $sena_pagada = $payment->transaction_amount; // Monto pagado (seña)
            $stmtUpdateReserva = $pdo->prepare("
                UPDATE reservas 
                SET status = 'confirmado', sena_pagada = :sena_pagada 
                WHERE id = :id
            ");
            $stmtUpdateReserva->execute([
                ':sena_pagada' => $sena_pagada,
                ':id' => $reserva_id
            ]);
            
            // Marcar horario como no disponible (ahora que el pago es exitoso)
            $stmtUpdateHorario = $pdo->prepare("UPDATE horarios SET disponible = 'no' WHERE fecha = :fecha AND hora = :hora");
            $stmtUpdateHorario->execute([
                ':fecha' => $reserva['fecha'],
                ':hora' => $reserva['hora']
            ]);
        }
    } elseif ($payment && $payment->status === 'rejected') {
        // Pago rechazado: Eliminar la reserva pendiente para liberar el slot (opcional, dependiendo de tu lógica)
        $reserva_id = $payment->external_reference;
        $stmtDelete = $pdo->prepare("DELETE FROM reservas WHERE id = :id AND status = 'pendiente'");
        $stmtDelete->execute([':id' => $reserva_id]);
    }
}

// Responder con HTTP 200 para confirmar recepción del webhook
http_response_code(200);
?>