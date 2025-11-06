<?php
// crear_preferencia.php
// Crea preferencia de pago sin insertar reserva en DB hasta confirmación en capturar.php.

header('Content-Type: application/json');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../php/conexion.php';

MercadoPago\SDK::setAccessToken('APP_USR-2122609768538338-110110-699cf51ac71548b571a1d3f298b66992-283482986');

// Recibir datos del frontend
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || empty($data['user_id']) || empty($data['date']) || empty($data['time']) || empty($data['category_key']) || empty($data['sub_table']) || empty($data['sub_id']) || empty($data['subservicio_name']) || empty($data['sena'])) {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
    exit;
}

// Validar horario disponible
$stmtCheck = $pdo->prepare("SELECT disponible FROM horarios WHERE fecha = :fecha AND hora = :hora");
$stmtCheck->execute([':fecha' => $data['date'], ':hora' => $data['time']]);
$disponible = $stmtCheck->fetchColumn();

if ($disponible !== 'si') {
    echo json_encode(['success' => false, 'error' => 'Horario no disponible']);
    exit;
}

// Crear preferencia
$preference = new MercadoPago\Preference();

$item = new MercadoPago\Item();
$item->id = 'turno_' . $data['sub_id'];
$item->title = $data['subservicio_name'] . ' (Seña)';
$item->quantity = 1;
$item->unit_price = (float) $data['sena'];
$item->currency_id = 'ARS';

$preference->items = array($item);

$preference->back_urls = array(
    "success" => "https://peluqueriagold.free.nf/php/capturar.php",
    "failure" => "https://peluqueriagold.free.nf/php/turno.php"
);

$preference->notification_url = "https://peluqueriagold.free.nf/php/webhook_mercadopago.php"; // Puedes dejarlo, pero como no lo usas, ignóralo o remuévelo.

$external_reference = implode('|', [
    $data['user_id'],
    $data['date'],
    $data['time'],
    $data['category_key'],
    $data['sub_table'],
    $data['sub_id'],
    $data['subservicio_name'],
    $data['sena']
]);
$preference->external_reference = $external_reference;

$preference->auto_return = 'approved'; // Redirección automática en éxito

$preference->save();

if (!$preference->id) {
    echo json_encode(['success' => false, 'error' => 'Error al crear preferencia en Mercado Pago']);
    exit;
}

echo json_encode(['success' => true, 'init_point' => $preference->init_point]);
?>