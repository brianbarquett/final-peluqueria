<?php
session_start();
require_once '../conexion.php';

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['idusuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index_principal.php");
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /html/registro.html?mode=login");
    exit;
}

// Fetch all turnos
$stmt = $pdo->query("SELECT r.*, u.nombre AS user_name FROM reservas r JOIN usuarios u ON r.id_usuario = u.idusuario ORDER BY r.fecha DESC, r.hora DESC");
$turnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Turnos Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">BarberShop Gold Style - Admin Turnos</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-2"><?php echo htmlspecialchars($_SESSION["nombre"] ?? 'Admin'); ?></span>
                <a href="?logout=1" class="text-white"><i class="bi bi-box-arrow-right fs-4"></i></a>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <h2>Turnos Reservados</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Servicio</th>
                    <th>Subservicio</th>
                    <th>Seña Pagada</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($turnos as $turno): ?>
                    <tr>
                        <td><?php echo $turno['id_reserva']; ?></td>
                        <td><?php echo htmlspecialchars($turno['user_name']); ?></td>
                        <td><?php echo $turno['fecha']; ?></td>
                        <td><?php echo $turno['hora']; ?></td>
                        <td><?php echo htmlspecialchars($turno['category_key']); ?></td>
                        <td><?php echo htmlspecialchars($turno['subservicio_name']); ?></td>
                        <td>$<?php echo number_format($turno['sena_pagada'], 2); ?></td>
                        <td><?php echo htmlspecialchars($turno['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>