<?php
session_start();
require 'conexion.php';

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['idusuario'])) {
    header("Location: index_principal.php");
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /html/registro.html?mode=login");
    exit;
}

// Fetch foto
$user_id = $_SESSION['idusuario'];
$stmtFoto = $pdo->prepare("SELECT foto FROM usuarios WHERE idusuario = :id");
$stmtFoto->execute([':id' => $user_id]);
$user_foto = $stmtFoto->fetchColumn() ?: 'https://via.placeholder.com/40';

// Fetch turnos activos
$current_date = date('Y-m-d');
$current_time = date('H:i:s');
$stmtActivos = $pdo->prepare("
    SELECT * FROM reservas 
    WHERE id_usuario = :id 
    AND (status = 'pendiente' OR status = 'ocupado') 
    AND (fecha > :current_date OR (fecha = :current_date AND hora >= :current_time))
    ORDER BY fecha ASC, hora ASC
");
$stmtActivos->execute([':id' => $user_id, ':current_date' => $current_date, ':current_time' => $current_time]);
$turnosActivos = $stmtActivos->fetchAll();

// Fetch historial
$stmtHistorial = $pdo->prepare("
    SELECT * FROM reservas 
    WHERE id_usuario = :id 
    AND NOT ((status = 'pendiente' OR status = 'ocupado') 
    AND (fecha > :current_date OR (fecha = :current_date AND hora >= :current_time)))
    ORDER BY fecha DESC, hora DESC
");
$stmtHistorial->execute([':id' => $user_id, ':current_date' => $current_date, ':current_time' => $current_time]);
$turnosHistorial = $stmtHistorial->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Turnos - BarberShop Gold Style</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding-top: 80px;
            padding-bottom: 50px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-container {
            max-width: 1100px;
            margin: 0 auto;
        }
        
        .page-title {
            color: #ffffff;
            font-weight: 700;
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 40px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            letter-spacing: 1px;
        }
        
        .section-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 30px;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
        }
        
        .section-header {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 25px;
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 3px solid #667eea;
        }
        
        .table-container {
            overflow-x: auto;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .custom-table {
            margin: 0 auto;
            border-radius: 15px;
            overflow: hidden;
            background: white;
        }
        
        .custom-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .custom-table thead th {
            padding: 15px;
            font-weight: 600;
            text-align: center;
            border: none;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
        }
        
        .custom-table tbody td {
            padding: 15px;
            text-align: center;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
            font-size: 0.9rem;
        }
        
        .custom-table tbody tr {
            transition: all 0.3s ease;
        }
        
        .custom-table tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .custom-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .btn-descargar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-descargar:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .btn-toggle {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 30px;
            padding: 12px 40px;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .btn-toggle:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .btn-toggle:focus {
            outline: none;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
            font-size: 1.1rem;
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-pendiente {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-ocupado {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status-completado {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-cancelado {
            background-color: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .section-card {
                padding: 20px;
            }
            
            .custom-table {
                font-size: 0.85rem;
            }
            
            .custom-table thead th,
            .custom-table tbody td {
                padding: 10px 5px;
            }
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index_cliente.php">BarberShop Gold Style</a>
            <div class="boton-nav d-flex align-items-center">
                <a href="mis_turnos.php" class="text-white me-2"><i class="bi bi-calendar-check fs-4"></i></a>
                <span class="text-white me-2"><?php echo htmlspecialchars($_SESSION["nombre"] ?? 'Usuario'); ?></span>
                <div class="dropdown">
                    <img src="uploads/<?php echo htmlspecialchars($user_foto); ?>?t=<?php echo time(); ?>" alt="Foto de Perfil" class="rounded-circle me-2 dropdown-toggle" style="width: 40px; height: 40px; object-fit: cover; cursor: pointer;" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePhotoModal">Cambiar foto</a></li>
                    </ul>
                </div>
                <a href="config_cliente.php" class="text-white me-2"><i class="bi bi-gear fs-4"></i></a>
                <a href="?logout=1" class="text-white"><i class="bi bi-box-arrow-right fs-4"></i></a>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="main-container">
        <h1 class="page-title">Mis Turnos</h1>

        <!-- Turnos Activos -->
        <div class="section-card">
            <h2 class="section-header">
                <i class="bi bi-calendar-check me-2"></i>Turnos Activos
            </h2>
            
            <div class="table-container">
                <?php if (empty($turnosActivos)): ?>
                    <div class="empty-state">
                        <i class="bi bi-calendar-x"></i>
                        <p>No tienes turnos activos en este momento.</p>
                    </div>
                <?php else: ?>
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Servicio</th>
                                <th>Subservicio</th>
                                <th>Seña</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($turnosActivos as $turno): ?>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($turno['fecha'])); ?></td>
                                    <td><?php echo date('H:i', strtotime($turno['hora'])); ?></td>
                                    <td><?php echo htmlspecialchars($turno['category_key']); ?></td>
                                    <td><?php echo htmlspecialchars($turno['subservicio_name']); ?></td>
                                    <td><strong>$<?php echo number_format($turno['sena_pagada'], 2); ?></strong></td>
                                    <td>
                                        <span class="status-badge status-<?php echo htmlspecialchars($turno['status']); ?>">
                                            <?php echo ucfirst(htmlspecialchars($turno['status'])); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="descargar_comprobante.php?id_reserva=<?php echo $turno['id_reserva']; ?>" class="btn-descargar">
                                            <i class="bi bi-download me-1"></i>PDF
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <!-- Botón Toggle Historial -->
        <div class="text-center mb-4">
            <button class="btn btn-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#historialCollapse" aria-expanded="false" aria-controls="historialCollapse">
                <i class="bi bi-clock-history me-2"></i>Ver Historial de Turnos
            </button>
        </div>

        <!-- Historial de Turnos (Collapse) -->
        <div class="collapse" id="historialCollapse">
            <div class="section-card">
                <h2 class="section-header">
                    <i class="bi bi-clock-history me-2"></i>Historial de Turnos
                </h2>
                
                <div class="table-container">
                    <?php if (empty($turnosHistorial)): ?>
                        <div class="empty-state">
                            <i class="bi bi-archive"></i>
                            <p>No tienes historial de turnos.</p>
                        </div>
                    <?php else: ?>
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Servicio</th>
                                    <th>Subservicio</th>
                                    <th>Seña</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($turnosHistorial as $turno): ?>
                                    <tr>
                                        <td><?php echo date('d/m/Y', strtotime($turno['fecha'])); ?></td>
                                        <td><?php echo date('H:i', strtotime($turno['hora'])); ?></td>
                                        <td><?php echo htmlspecialchars($turno['category_key']); ?></td>
                                        <td><?php echo htmlspecialchars($turno['subservicio_name']); ?></td>
                                        <td><strong>$<?php echo number_format($turno['sena_pagada'], 2); ?></strong></td>
                                        <td>
                                            <span class="status-badge status-<?php echo htmlspecialchars($turno['status']); ?>">
                                                <?php echo ucfirst(htmlspecialchars($turno['status'])); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="descargar_comprobante.php?id_reserva=<?php echo $turno['id_reserva']; ?>" class="btn-descargar">
                                                <i class="bi bi-download me-1"></i>PDF
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cambiar Foto -->
    <div class="modal fade" id="changePhotoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <h5 class="modal-title">Cambiar Foto de Perfil</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="guardar_foto.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="foto" class="form-label">Selecciona una nueva foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                            <div class="form-text">Formatos: JPG, PNG. Tamaño máximo: 5MB</div>
                        </div>
                        <button type="submit" class="btn btn-toggle w-100">
                            <i class="bi bi-upload me-2"></i>Guardar Foto
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>