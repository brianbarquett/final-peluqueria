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
    <title>Mis Turnos - Gold Style</title>
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
        /* ==================== FOOTER ==================== */
        /* Agrega estos estilos a tu footer.css o a un stylesheet global */

        /* Asegura que el footer ocupe todo el ancho y se quede al fondo */
        .footer {
            width: 100%; /* Ancho completo */
            flex-shrink: 0; /* No permite que se encoja */
            margin-top: auto; /* Lo empuja al fondo si el contenido es corto */
        }
        :root {
            --gold-primary: #D4AF37;
            --gold-light: #F4E5B1;
            --gold-dark: #B8941E;
            --black-primary: #0a0a0a;
            --black-secondary: #1a1a1a;
            --black-light: #2d2d2d;
            --white: #ffffff;
        }
        .footer {
            background: linear-gradient(180deg, var(--black-secondary) 0%, var(--black-primary) 100%);
            border-top: 3px solid var(--gold-dark);
            padding: 60px 0 0 0;
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold-primary), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 1; }
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 30px 40px 30px;
        }

        .footer-section {
            animation: fadeInUp 0.8s ease-out;
        }

        .footer-section h3 {
            color: var(--gold-primary);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: linear-gradient(90deg, var(--gold-primary), transparent);
        }

        .footer-section p {
            color: var(--gold-light);
            line-height: 1.8;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: var(--gold-light);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            font-size: 0.95rem;
        }

        .footer-links a::before {
            content: '▸';
            margin-right: 8px;
            color: var(--gold-primary);
            transition: transform 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--gold-primary);
            padding-left: 5px;
        }

        .footer-links a:hover::before {
            transform: translateX(5px);
        }

        /* Redes Sociales */
        .social-links {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            background: var(--black-light);
            border: 2px solid var(--gold-dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold-primary);
            font-size: 1.2rem;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .social-links a::before {
            content: '';
            position: absolute;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold-primary), var(--gold-dark));
            transition: all 0.4s ease;
            z-index: 0;
        }

        .social-links a:hover::before {
            width: 100%;
            height: 100%;
        }

        .social-links a:hover {
            border-color: var(--gold-primary);
            transform: translateY(-5px) rotate(360deg);
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.4);
        }

        .social-links a i {
            position: relative;
            z-index: 1;
            transition: color 0.3s ease;
        }

        .social-links a:hover i {
            color: var(--black-primary);
        }

        /* Información de contacto */
        .contact-info {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .contact-info li {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: var(--gold-light);
            font-size: 0.95rem;
        }

        .contact-info i {
            color: var(--gold-primary);
            font-size: 1.1rem;
            margin-right: 12px;
            min-width: 20px;
        }

        /* Barra de copyright */
        .footer-bottom {
            background: var(--black-primary);
            border-top: 1px solid var(--gold-dark);
            padding: 25px 30px;
            text-align: center;
        }

        .footer-bottom-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .copyright {
            color: var(--gold-light);
            font-size: 0.9rem;
        }

        .designer {
            color: var(--gold-light);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .designer i {
            color: var(--gold-primary);
            animation: heartbeat 1.5s infinite;
        }

        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.2); }
            50% { transform: scale(1); }
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .designer-name {
            font-weight: 700;
            background: linear-gradient(135deg, var(--gold-primary) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* RESPONSIVE - Footer */
        @media (max-width: 767px) {
            .footer {
                padding: 40px 0 0 0;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
                padding: 0 20px 30px 20px;
            }

            .footer-section h3 {
                font-size: 1.3rem;
            }

            .footer-bottom {
                padding: 20px 15px;
            }

            .footer-bottom-content {
                flex-direction: column;
                text-align: center;
            }

            .social-links {
                justify-content: center;
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) {
            .footer-content {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Estilos adicionales para navbar */
        .navbar .navbar-collapse {
            background: var(--black-secondary);
            border-top: 1px solid var(--gold-dark);
        }
        .navbar .navbar-nav .nav-link {
            color: var(--gold-light) !important;
            padding: 10px 20px;
        }
        .navbar .navbar-nav .nav-link:hover {
            color: var(--gold-primary) !important;
        }
        /* Ocultar toggler en desktop */
        @media (min-width: 768px) {
            .navbar-toggler {
                display: none;
            }
        }
        /* Estilos para desktop */
        @media (min-width: 768px) {
            .desktop-nav {
                display: flex !important;
            }
            .mobile-user-name {
                display: none;
            }
            .mobile-change-photo {
                display: none;
            }
        }
        /* Estilos para mobile */
        @media (max-width: 767px) {
            .desktop-nav {
                display: none !important;
            }
            .user-info-desktop {
                display: none;
            }
            .user-info-mobile img {
                margin-right: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- NAVBAR MODIFICADA -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index_cliente.php"><i class="bi bi-arrow-left-circle"></i>Gold Style</a>
            <!-- Foto de perfil visible en mobile al lado del toggler -->
            <div class="user-info-mobile d-flex align-items-center d-md-none me-2">
                <img src="uploads/<?php echo htmlspecialchars($user_foto); ?>?t=<?php echo time(); ?>" alt="Foto de Perfil" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
            </div>
            <!-- Botón hamburguesa solo en mobile -->
            <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Elementos en desktop: nombre, foto con dropdown, turnos, logout -->
            <div class="user-info-desktop d-none d-md-flex align-items-center">
                <span class="text-white me-2"><?php echo htmlspecialchars($_SESSION["nombre"] ?? 'Usuario'); ?></span>
                <div class="dropdown me-3">
                    <img src="uploads/<?php echo htmlspecialchars($user_foto); ?>?t=<?php echo time(); ?>" alt="Foto de Perfil" class="rounded-circle dropdown-toggle" style="width: 40px; height: 40px; object-fit: cover;" id="profileDropdownDesktop" data-bs-toggle="dropdown" aria-expanded="false">
                    <ul class="dropdown-menu" aria-labelledby="profileDropdownDesktop">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePhotoModal">Cambiar foto</a></li>
                    </ul>
                </div>
                <!-- Íconos en desktop -->
                <div class="desktop-nav d-flex align-items-center">
                    <a href="mis_turnos.php" class="text-white me-3"><i class="bi bi-calendar-check fs-4"></i></a>
                    <a href="#" class="text-white logout-link"><i class="bi bi-box-arrow-right fs-4"></i></a>
                </div>
            </div>
            <!-- Menú collapse para mobile -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mobile-user-name d-md-none">
                        <span class="nav-link"><?php echo htmlspecialchars($_SESSION["nombre"] ?? 'Usuario'); ?></span>
                    </li>
                    <li class="nav-item mobile-change-photo d-md-none">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#changePhotoModal">Cambiar foto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-redirect" href="mis_turnos.php"><i class="bi bi-calendar-check me-2"></i>Mis Turnos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-link" href="#"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a>
                    </li>
                </ul>
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
    <!-- Modal Confirmar Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: linear-gradient(145deg, var(--black-secondary) 0%, var(--black-primary) 100%); border: 2px solid var(--gold-dark); color: var(--white); border-radius: 20px;">
                <div class="modal-header" style="background: linear-gradient(135deg, var(--gold-primary) 0%, var(--gold-dark) 100%); border: none; border-radius: 18px 18px 0 0;">
                    <h5 class="modal-title" style="color: var(--black-primary); font-weight: 700; letter-spacing: 2px;">Cerrar Sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="padding: 30px;">
                    <i class="bi bi-box-arrow-right" style="font-size: 3rem; color: var(--gold-primary); margin-bottom: 20px; display: block;"></i>
                    <p style="color: var(--gold-light); font-size: 1.1rem; margin-bottom: 0;">¿Estás seguro de que deseas cerrar sesión?</p>
                </div>
                <div class="modal-footer justify-content-center" style="border: none; background: var(--black-secondary); border-radius: 0 0 18px 18px; padding: 20px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: var(--black-light); border: 2px solid var(--gold-dark); color: var(--gold-light); border-radius: 10px; padding: 10px 25px; font-weight: 600;">Cancelar</button>
                    <button type="button" id="confirmLogout" class="btn btn-primary" style="background: linear-gradient(135deg, var(--gold-primary) 0%, var(--gold-dark) 100%); border: none; color: var(--black-primary); border-radius: 10px; padding: 10px 25px; font-weight: 700; transition: all 0.3s ease;">Sí, cerrar sesión</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-content">
            <!-- Sobre Gold Style -->
            <div class="footer-section">
                <h3>💈 Gold Style</h3>
                <p>
                    Barbería de élite donde el estilo se encuentra con la tradición. 
                    Ofrecemos servicios de alta calidad para el caballero moderno.
                </p>
                <p>
                    <strong>Horarios:</strong><br>
                    Lun - Sáb: 9:00 AM - 8:00 PM<br>
                    Dom: 10:00 AM - 4:00 PM
                </p>
            </div>

            <!-- Enlaces Rápidos -->
            <div class="footer-section">
                <h3>Enlaces Rápidos</h3>
                <ul class="footer-links">
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Sacar Turno</a></li>
                    <li><a href="#">Mis Turnos</a></li>
                    <li><a href="#">Cortes</a></li>
                    <li><a href="#">Barbas</a></li>
                </ul>
            </div>

            <!-- Redes Sociales -->
            <div class="footer-section">
                <h3>Síguenos</h3>
                <p>Conéctate con nosotros en redes sociales</p>
                <div class="social-links">
                    <a href="https://facebook.com" target="_blank" title="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://instagram.com" target="_blank" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://twitter.com" target="_blank" title="Twitter">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="https://whatsapp.com" target="_blank" title="WhatsApp">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <a href="https://tiktok.com" target="_blank" title="TikTok">
                        <i class="bi bi-tiktok"></i>
                    </a>
                </div>
            </div>

            <!-- Contacto -->
            <div class="footer-section">
                <h3>Contacto</h3>
                <ul class="contact-info">
                    <li>
                        <i class="bi bi-geo-alt-fill"></i>
                        Calle 46 68, La Plata piso 2
                    </li>
                    <li>
                        <i class="bi bi-telephone-fill"></i>
                        +54 123 456 7890
                    </li>
                    <li>
                        <i class="bi bi-envelope-fill"></i>
                        info@goldstyle.com
                    </li>
                    <li>
                        <i class="bi bi-clock-fill"></i>
                        Lun-Sáb: 9AM - 8PM
                    </li>
                </ul>
            </div>
        </div>

        <!-- Barra inferior con copyright -->
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <div class="copyright">
                    &copy; <?php echo date('Y'); ?> Gold Style BarberShop. Todos los derechos reservados.
                </div>
                <div class="designer">
                    Designed with <i class="bi bi-heart-fill"></i> by 
                    <span class="designer-name">BrianBarquett</span>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript para confirmación de logout y navegación en mobile -->
    <script>
        // Para logout
        document.querySelectorAll('.logout-link').forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                // Cerrar menú en mobile si está abierto
                const collapseElement = document.getElementById('navbarNav');
                const bsCollapse = bootstrap.Collapse.getInstance(collapseElement);
                if (bsCollapse && bsCollapse._isShown()) {
                    bsCollapse.hide();
                }
                // Abrir modal
                const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
                logoutModal.show();
            });
        });

        // Confirmar logout en el modal
        document.getElementById('confirmLogout').addEventListener('click', function() {
            window.location.href = '?logout=1';
        });

        // Para links de redirección en mobile (como Mis Turnos)
        document.querySelectorAll('.nav-redirect').forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const href = this.getAttribute('href');
                if (href && href !== '#') {
                    // Cerrar menú
                    const collapseElement = document.getElementById('navbarNav');
                    const bsCollapse = bootstrap.Collapse.getInstance(collapseElement);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                    // Redirigir después de cerrar
                    setTimeout(() => {
                        window.location.href = href;
                    }, 300); // Delay para la animación de cierre
                }
            });
        });
    </script>
</body>
</html>