<?php
session_start();
require 'conexion.php';

// Requiere Dompdf
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_SESSION['idusuario'])) {
    header("Location: index_principal.php");
    exit;
}

if (!isset($_GET['id_reserva'])) {
    header("Location: mis_turnos.php");
    exit;
}

$id_reserva = $_GET['id_reserva'];
$user_id = $_SESSION['idusuario'];

// Fetch reserva con información del usuario
$stmt = $pdo->prepare("
    SELECT r.*, u.nombre, u.correo, u.telefono 
    FROM reservas r 
    JOIN usuarios u ON r.id_usuario = u.idusuario 
    WHERE r.id_reserva = :id_reserva AND r.id_usuario = :id_usuario
");
$stmt->execute([':id_reserva' => $id_reserva, ':id_usuario' => $user_id]);
$reserva = $stmt->fetch();

if (!$reserva) {
    header("Location: mis_turnos.php");
    exit;
}

// Formatear fecha y hora
$fecha_formateada = date('d/m/Y', strtotime($reserva['fecha']));
$hora_formateada = date('H:i', strtotime($reserva['hora']));
$fecha_generacion = date('d/m/Y H:i:s');

// Obtener día de la semana en español
$dias_semana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
$dia_semana_turno = $dias_semana[date('w', strtotime($reserva['fecha']))];
$fecha_turno_completa = $dia_semana_turno . ' ' . $fecha_formateada;

// Calcular monto total (seña es el 50%)
$monto_total = $reserva['sena_pagada'] * 2;
$saldo_pendiente = $reserva['sena_pagada'];

// Determinar color y texto del estado
$status_info = [
    'pendiente' => ['color' => '#ffc107', 'bg' => '#fff3cd', 'text' => 'Pendiente'],
    'ocupado' => ['color' => '#17a2b8', 'bg' => '#d1ecf1', 'text' => 'Confirmado'],
    'completado' => ['color' => '#28a745', 'bg' => '#d4edda', 'text' => 'Completado'],
    'cancelado' => ['color' => '#dc3545', 'bg' => '#f8d7da', 'text' => 'Cancelado']
];
$status = $status_info[$reserva['status']] ?? ['color' => '#6c757d', 'bg' => '#e9ecef', 'text' => 'Desconocido'];

// Generar HTML elegante para el PDF
$html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
            size: A4;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Helvetica", "Arial", sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px;
            color: #333;
        }
        .comprobante {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 30px 20px 30px;
            text-align: center;
            position: relative;
        }
        .logo {
            font-size: 36px;
            font-weight: bold;
            letter-spacing: 3px;
            margin-bottom: 5px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            text-transform: uppercase;
        }
        .logo-shine {
            background: linear-gradient(to right, #ffffff 0%, #ffd700 50%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .subtitle {
            font-size: 16px;
            opacity: 0.95;
            letter-spacing: 2px;
            font-weight: 300;
        }
        .header-wave {
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 40px;
            background: white;
            border-radius: 0 0 50% 50%;
        }
        .content {
            padding: 25px 30px 20px 30px;
        }
        .comprobante-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .comprobante-subtitle {
            text-align: center;
            color: #28a745;
            font-size: 13px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .reserva-number {
            text-align: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 12px;
            border-radius: 15px;
            margin-bottom: 20px;
            border: 2px dashed #667eea;
        }
        .reserva-number-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        .reserva-number-value {
            font-size: 20px;
            font-weight: bold;
            color: #667eea;
            letter-spacing: 2px;
        }
        .section {
            margin-bottom: 20px;
            background: #f8f9fa;
            padding: 18px;
            border-radius: 15px;
            border-left: 5px solid #667eea;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #667eea;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 15px;
            text-align: center;
        }
        .section-icon {
            font-size: 20px;
            margin-right: 10px;
        }
        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            padding: 10px 20px 10px 0;
            font-weight: 600;
            color: #555;
            font-size: 13px;
            width: 45%;
            border-bottom: 1px solid #e9ecef;
        }
        .info-value {
            display: table-cell;
            padding: 10px 0;
            color: #333;
            font-size: 13px;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child .info-label,
        .info-row:last-child .info-value {
            border-bottom: none;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: bold;
            color: ' . $status['color'] . ';
            background: ' . $status['bg'] . ';
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 2px solid ' . $status['color'] . ';
        }
        .highlight-date {
            font-size: 18px;
            font-weight: bold;
            color: #667eea;
        }
        .amounts-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin: 20px 0;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        .amounts-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 18px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .amount-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 14px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .amount-row:last-child {
            border-bottom: none;
        }
        .amount-row.total {
            margin-top: 12px;
            padding-top: 15px;
            border-top: 2px solid white;
            font-size: 17px;
            font-weight: bold;
        }
        .amount-paid {
            color: #90EE90;
            font-weight: bold;
        }
        .important-box {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 3px solid #ffc107;
            border-radius: 15px;
            padding: 18px;
            margin: 18px 0;
        }
        .important-title {
            font-size: 14px;
            font-weight: bold;
            color: #856404;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .important-list {
            color: #856404;
            font-size: 12px;
            line-height: 1.8;
        }
        .important-item {
            margin-bottom: 6px;
            padding-left: 20px;
            position: relative;
        }
        .important-item:before {
            content: "✓";
            position: absolute;
            left: 0;
            font-weight: bold;
            color: #28a745;
        }
        .footer {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 20px 30px;
            text-align: center;
        }
        .footer-brand {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 12px;
            letter-spacing: 2px;
        }
        .footer-info {
            font-size: 12px;
            line-height: 1.8;
            color: white;
        }
        .footer-divider {
            height: 1px;
            background: rgba(255,255,255,0.3);
            margin: 15px auto;
            width: 80%;
        }
        .footer-date {
            font-size: 11px;
            color: white;
            margin-top: 12px;
            font-style: italic;
        }
        .watermark {
            text-align: center;
            color: #999;
            font-size: 10px;
            margin-top: 15px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="comprobante">
        <!-- Header Elegante -->
        <div class="header">
            <div class="logo">
                <span class="logo-shine">GOLD STYLE</span>
            </div>
            <div class="subtitle">Premium BarberShop & Beauty</div>
            <div class="header-wave"></div>
        </div>

        <!-- Contenido Principal -->
        <div class="content">
            <!-- Título -->
            <div class="comprobante-title">COMPROBANTE DE RESERVA</div>
            <div class="comprobante-subtitle">Gracias por elegirnos, ' . htmlspecialchars($reserva['nombre']) . '!</div>

            <!-- Número de Reserva Destacado -->
            <div class="reserva-number">
                <div class="reserva-number-label">Número de Reserva</div>
                <div class="reserva-number-value">#' . str_pad($reserva['id_reserva'], 6, '0', STR_PAD_LEFT) . '</div>
            </div>

            <!-- Información del Cliente -->
            <div class="section">
                <div class="section-title">DATOS DEL CLIENTE</div>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Nombre Completo:</div>
                        <div class="info-value">' . htmlspecialchars($reserva['nombre']) . '</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Correo Electrónico:</div>
                        <div class="info-value">' . htmlspecialchars($reserva['correo']) . '</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Teléfono:</div>
                        <div class="info-value">' . htmlspecialchars($reserva['telefono'] ?? 'No especificado') . '</div>
                    </div>
                </div>
            </div>

            <!-- Detalles del Turno -->
            <div class="section">
                <div class="section-title">DETALLES DEL TURNO</div>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Fecha del Turno:</div>
                        <div class="info-value"><span class="highlight-date">' . $fecha_turno_completa . '</span></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Horario:</div>
                        <div class="info-value"><span class="highlight-date">' . $hora_formateada . ' hs</span></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Categoría:</div>
                        <div class="info-value">' . htmlspecialchars($reserva['category_key']) . '</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Servicio:</div>
                        <div class="info-value">' . htmlspecialchars($reserva['subservicio_name']) . '</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Estado de Reserva:</div>
                        <div class="info-value">
                            <span class="status-badge">' . $status['text'] . '</span>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Seña Pagada:</div>
                        <div class="info-value"><strong style="color: #28a745;">$' . number_format($reserva['sena_pagada'], 2, ',', '.') . '</strong></div>
                    </div>
                </div>
            </div>

            <!-- Resumen de Pagos -->
            <div class="amounts-section">
                <div class="amounts-title">RESUMEN DE PAGOS</div>
                <div class="amount-row">
                    <span>Precio Total del Servicio:</span>
                    <span>$' . number_format($monto_total, 2, ',', '.') . '</span>
                </div>
                <div class="amount-row">
                    <span>Saldo a Pagar en el Local:</span>
                    <span>$' . number_format($saldo_pendiente, 2, ',', '.') . '</span>
                </div>
                <div class="amount-row total">
                    <span>Seña Abonada:</span>
                    <span class="amount-paid">$' . number_format($reserva['sena_pagada'], 2, ',', '.') . '</span>
                </div>
            </div>

            <!-- Información Importante -->
            <div class="important-box">
                <div class="important-title">⚠️ INFORMACIÓN IMPORTANTE</div>
                <div class="important-list">
                    <div class="important-item">Presenta este comprobante al llegar a tu cita</div>
                    <div class="important-item">Por favor, llega 5-10 minutos antes de tu horario</div>
                    <div class="important-item">El saldo pendiente se abona en efectivo o tarjeta en el local</div>
                    <div class="important-item">Para cancelar o reprogramar, contacta con 24hs de anticipación</div>
                    <div class="important-item">En caso de demora, comunícate para no perder tu turno</div>
                </div>
            </div>

            <div class="watermark">
                Este documento es válido sin firma ni sello
            </div>
        </div>

        <!-- Footer Elegante -->
        <div class="footer">
            <div class="footer-brand">GOLD STYLE BARBERSHOP</div>
            <div class="footer-info">
                📍 Av. Principal 1234, Ciudad Autónoma | 📞 +54 123 456-7890<br>
                📧 info@goldstyle.com | 🌐 www.goldstyle.com<br>
                Horario: Lun-Sáb 9:00 - 20:00 | Dom 10:00 - 14:00
            </div>
            <div class="footer-divider"></div>
            <div class="footer-date">
                Comprobante generado el ' . $fecha_generacion . '
            </div>
        </div>
    </div>
</body>
</html>';

// Configurar Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'Helvetica');
$options->set('dpi', 150);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Enviar PDF como descarga
$filename = 'GoldStyle_Comprobante_' . str_pad($id_reserva, 6, '0', STR_PAD_LEFT) . '.pdf';
$dompdf->stream($filename, ['Attachment' => true]);
?>