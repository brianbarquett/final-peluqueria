<?php
// crear_preferencia.php
// Este script crea una preferencia de pago en Mercado Pago basada en los datos recibidos del frontend (turno.php).
// Adaptado de mercado_pago.php, pero dinámico con los datos del subservicio y la seña.
// También inserta la reserva en la base de datos con status 'pendiente'.
// Después del pago exitoso en Mercado Pago, necesitarías un webhook o callback para actualizar el status a 'confirmado' o similar,
// pero eso no está implementado aquí (puedes agregar un notification_url en la preferencia).

header('Content-Type: application/json'); // Responder en JSON

require __DIR__ . '/../vendor/autoload.php'; // Asegúrate de que la ruta al autoload sea correcta
require __DIR__ . '/../php/conexion.php'; // Incluir la conexión a la DB (ajusta la ruta si es necesario)

MercadoPago\SDK::setAccessToken('APP_USR-1969609096585871-110110-c92e7e04539d841305e3b9b96f45732b-2959473413'); // Tu access token

// Recibir datos del frontend via POST (JSON)
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || empty($data['user_id']) || empty($data['date']) || empty($data['time']) || empty($data['category_key']) || empty($data['sub_table']) || empty($data['sub_id']) || empty($data['subservicio_name']) || empty($data['sena'])) {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
    exit;
}

// Validar si el horario está disponible (para evitar reservas duplicadas)
$stmtCheck = $pdo->prepare("SELECT disponible FROM horarios WHERE fecha = :fecha AND hora = :hora");
$stmtCheck->execute([':fecha' => $data['date'], ':hora' => $data['time']]);
$disponible = $stmtCheck->fetchColumn();

if ($disponible !== 'si') {
    echo json_encode(['success' => false, 'error' => 'Horario no disponible']);
    exit;
}

// Crear la preferencia de Mercado Pago
$preference = new MercadoPago\Preference();

$item = new MercadoPago\Item();
$item->id = 'turno_' . $data['sub_id']; // ID único basado en el subservicio
$item->title = $data['subservicio_name'] . ' (Seña)'; // Título del item: subservicio + indicación de seña
$item->quantity = 1;
$item->unit_price = (float) $data['sena']; // Monto de la seña (mitad del precio)
$item->currency_id = 'ARS';

$preference->items = array($item);

// Opcional: Agregar URL de notificación (webhook) para actualizar el status después del pago
// $preference->notification_url = 'https://tu-sitio.com/php/webhook_mercadopago.php'; // Implementa esto por separado

$preference->save();

if (!$preference->id) {
    echo json_encode(['success' => false, 'error' => 'Error al crear preferencia en Mercado Pago']);
    exit;
}

// Insertar la reserva en la DB con status 'pendiente' y sena_pagada = 0 (se actualizará después del pago exitoso)
$stmtInsert = $pdo->prepare("
    INSERT INTO reservas (id_usuario, fecha, hora, category_key, sub_table, sub_id, subservicio_name, sena_pagada, status)
    VALUES (:user_id, :fecha, :hora, :category_key, :sub_table, :sub_id, :subservicio_name, 0.00, 'pendiente')
");
$stmtInsert->execute([
    ':user_id' => $data['user_id'],
    ':fecha' => $data['date'],
    ':hora' => $data['time'],
    ':category_key' => $data['category_key'],
    ':sub_table' => $data['sub_table'],
    ':sub_id' => $data['sub_id'],
    ':subservicio_name' => $data['subservicio_name']
]);

// Marcar el horario como no disponible (ocupado)
$stmtUpdateHorario = $pdo->prepare("UPDATE horarios SET disponible = 'no' WHERE fecha = :fecha AND hora = :hora");
$stmtUpdateHorario->execute([':fecha' => $data['date'], ':hora' => $data['time']]);

// Responder con el init_point para redirigir al usuario a Mercado Pago
echo json_encode(['success' => true, 'init_point' => $preference->init_point]);
?>