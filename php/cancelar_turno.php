<?php
require 'conexion.php';

if (isset($_POST['id_reserva'])) {
    $id_reserva = (int) $_POST['id_reserva'];

    // Fetch fecha/hora para update horarios
    $stmt = $pdo->prepare("SELECT fecha, hora FROM reservas WHERE id_reserva = :id");
    $stmt->execute([':id' => $id_reserva]);
    $turno = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($turno) {
        $pdo->beginTransaction();

        // Update reservas status
        $stmtUpdateRes = $pdo->prepare("UPDATE reservas SET status = 'cancelado' WHERE id_reserva = :id");
        $stmtUpdateRes->execute([':id' => $id_reserva]);

        // Update horarios disponible = 'si'
        $stmtUpdateHor = $pdo->prepare("UPDATE horarios SET disponible = 'si' WHERE fecha = :fecha AND hora = :hora");
        $stmtUpdateHor->execute([':fecha' => $turno['fecha'], ':hora' => $turno['hora']]);

        $pdo->commit();
    }
}

header("Location: turnos_admin.php?success=1");
exit;