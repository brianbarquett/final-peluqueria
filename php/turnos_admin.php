<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['idusuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index_principal.php");
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /html/registro.html?mode=login");
    exit;
}

// Fetch foto del admin
$user_id = $_SESSION['idusuario'];
$stmtFoto = $pdo->prepare("SELECT foto FROM usuarios WHERE idusuario = :id");
$stmtFoto->execute([':id' => $user_id]);
$user_foto = $stmtFoto->fetchColumn() ?: 'https://via.placeholder.com/40';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Turnos - BarberShop Gold Style</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root {
            --gold-primary: #D4AF37;
            --gold-light: #F4E5B1;
            --gold-dark: #B8941E;
            --black-primary: #1a1a1a;
            --black-secondary: #2d2d2d;
            --black-light: #3d3d3d;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%);
            min-height: 100vh;
            padding-top: 5rem;
            padding-bottom: 3.125rem;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--white);
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(212, 175, 55, 0.03) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        /* NAVBAR */
        .navbar {
            background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%) !important;
            border-bottom: 0.125rem solid var(--gold-dark);
            box-shadow: 0 0.125rem 1.25rem rgba(212, 175, 55, 0.2);
            backdrop-filter: blur(0.625rem);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: 0.125rem;
            color: var(--gold-primary) !important;
            text-shadow: 0 0 0.625rem rgba(212, 175, 55, 0.5);
        }

        .back-btn {
            color: var(--gold-light);
            text-decoration: none;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-btn:hover {
            color: var(--gold-primary);
            transform: translateX(-0.3125rem);
            text-shadow: 0 0 0.625rem rgba(212, 175, 55, 0.5);
        }

        .boton-nav .text-white {
            color: var(--gold-light) !important;
        }

        .boton-nav img {
            border: 0.125rem solid var(--gold-primary);
        }

        /* CONTENEDOR PRINCIPAL */
        .container {
            max-width: 75rem;
            position: relative;
            z-index: 1;
        }

        .page-title {
            color: var(--gold-primary);
            font-weight: 700;
            font-size: clamp(2rem, 4vw, 2.5rem);
            text-align: center;
            margin-bottom: 2.5rem;
            text-shadow: 0 0 1.25rem rgba(212, 175, 55, 0.5);
            letter-spacing: 0.125rem;
            text-transform: uppercase;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { filter: drop-shadow(0 0 0.625rem rgba(212, 175, 55, 0.5)); }
            to { filter: drop-shadow(0 0 1.25rem rgba(212, 175, 55, 0.8)); }
        }

        /* DÍAS */
        .days {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(7.5rem, 1fr));
            gap: 1rem;
            margin-bottom: 2.5rem;
            padding: 1.25rem;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 1.25rem;
            border: 0.125rem solid rgba(212, 175, 55, 0.2);
        }

        .day-button {
            background: linear-gradient(145deg, var(--black-light) 0%, var(--black-secondary) 100%);
            color: var(--gold-light);
            border: 0.125rem solid var(--gold-dark);
            padding: 0.9375rem 1.25rem;
            cursor: pointer;
            border-radius: 0.9375rem;
            transition: all 0.3s ease;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.0625rem;
            font-size: 0.9rem;
            box-shadow: 0 0.25rem 0.9375rem rgba(0, 0, 0, 0.3);
        }

        .day-button:hover {
            background: linear-gradient(135deg, var(--gold-dark) 0%, var(--gold-primary) 100%);
            color: var(--black-primary);
            transform: translateY(-0.1875rem);
            box-shadow: 0 0.5rem 1.5625rem rgba(212, 175, 55, 0.4);
            border-color: var(--gold-primary);
        }

        .day-button.selected {
            background: linear-gradient(135deg, var(--gold-primary) 0%, var(--gold-light) 100%) !important;
            color: var(--black-primary) !important;
            border-color: var(--gold-primary) !important;
            box-shadow: 0 0.5rem 1.5625rem rgba(212, 175, 55, 0.5);
            transform: scale(1.05);
        }

        /* TABLAS */
        .table-card {
            background: linear-gradient(145deg, #2d2d2d 0%, #1a1a1a 100%);
            border: 0.125rem solid var(--gold-dark);
            border-radius: 1.25rem;
            box-shadow: 0 0.625rem 1.875rem rgba(0,0,0,0.5), 0 0 1.25rem rgba(212, 175, 55, 0.1);
            padding: 1.875rem;
            margin-bottom: 1.875rem;
            overflow: hidden;
        }

        .table {
            margin: 0;
            color: var(--white);
        }

        .table thead {
            background: linear-gradient(135deg, var(--gold-primary) 0%, var(--gold-dark) 100%);
        }

        .table thead th {
            color: var(--black-primary);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.0625rem;
            padding: 1rem;
            border: none;
            font-size: 0.9rem;
        }

        .table tbody tr {
            background: rgba(45, 45, 45, 0.5);
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(212, 175, 55, 0.1);
            transform: translateX(0.3125rem);
        }

        .table tbody td {
            padding: 1rem;
            border-bottom: 0.0625rem solid rgba(212, 175, 55, 0.2);
            vertical-align: middle;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background: rgba(45, 45, 45, 0.7);
        }

        /* BOTONES */
        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            border: none !important;
            color: white !important;
            padding: 0.5rem 1rem;
            border-radius: 0.625rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-0.125rem);
            box-shadow: 0 0.5rem 1.25rem rgba(239, 68, 68, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--gold-primary) 0%, var(--gold-dark) 100%) !important;
            border: none !important;
            color: var(--black-primary) !important;
            padding: 0.75rem 2rem;
            border-radius: 1.875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.0625rem;
            transition: all 0.3s ease;
            box-shadow: 0 0.3125rem 1.25rem rgba(212, 175, 55, 0.4);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold-primary) 100%) !important;
            transform: translateY(-0.1875rem);
            box-shadow: 0 0.5rem 1.5625rem rgba(212, 175, 55, 0.6);
            color: var(--black-primary) !important;
        }

        /* SECCIÓN HISTORIAL */
        #historialSection {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(1.25rem); }
            to { opacity: 1; transform: translateY(0); }
        }

        #historialSection h3 {
            color: var(--gold-primary);
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 1.25rem;
            letter-spacing: 0.0625rem;
            text-align: center;
        }

        /* MENSAJE VACÍO */
        .empty-state {
            text-align: center;
            padding: 3.125rem 1.25rem;
            color: var(--gold-light);
            font-size: 1.1rem;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
            color: var(--gold-primary);
        }

        /* RESPONSIVE */
        @media (max-width: 767px) {
            .days {
                grid-template-columns: repeat(auto-fit, minmax(6.25rem, 1fr));
                gap: 0.625rem;
                padding: 1rem;
            }

            .day-button {
                padding: 0.75rem 1rem;
                font-size: 0.85rem;
            }

            .table-card {
                padding: 1rem;
                overflow-x: auto;
            }

            .table {
                font-size: 0.85rem;
            }

            .table thead th,
            .table tbody td {
                padding: 0.625rem 0.5rem;
            }

            .page-title {
                margin-bottom: 1.5rem;
            }
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar {
            width: 0.75rem;
            height: 0.75rem;
        }

        ::-webkit-scrollbar-track {
            background: var(--black-primary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gold-dark);
            border-radius: 0.375rem;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gold-primary);
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-dark fixed-top">
        <div class="container-fluid">
            <a href="index_admin.php" class="back-btn">
                <i class="bi bi-arrow-left fs-4"></i>
                <span>Volver</span>
            </a>
            <a class="navbar-brand" href="index_admin.php">
                <i class="bi bi-scissors me-2"></i>
                GOLD STYLE
            </a>
            <div class="boton-nav d-flex align-items-center">
                <span class="text-white me-2"><?php echo htmlspecialchars($_SESSION["nombre"] ?? 'Admin'); ?></span>
                <img src="uploads/<?php echo htmlspecialchars($user_foto); ?>?t=<?php echo time(); ?>" alt="Foto de Perfil" class="rounded-circle me-2" style="width: 2.5rem; height: 2.5rem; object-fit: cover;">
                <a href="config_admin.php" class="text-white me-2"><i class="bi bi-gear fs-4"></i></a>
                <a href="?logout=1" class="text-white"><i class="bi bi-box-arrow-right fs-4"></i></a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="page-title">
            <i class="bi bi-calendar-event me-2"></i>
            Gestión de Turnos
        </h1>

        <div class="days">
            <!-- Días generados por JS -->
        </div>

        <div id="turnosTable" class="table-card">
            <!-- Tabla de turnos cargada por JS -->
        </div>

        <div class="text-center mb-4">
            <button id="historialBtn" class="btn btn-secondary">
                <i class="bi bi-clock-history me-2"></i>Ver Historial Completo
            </button>
        </div>

        <div id="historialSection" style="display: none;">
            <h3><i class="bi bi-archive me-2"></i>Historial de Turnos</h3>
            <div class="table-card">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Servicio</th>
                            <th>Subservicio</th>
                            <th>Seña</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody id="historialBody">
                        <!-- Cargado por JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const daysContainer = document.querySelector('.days');
        const turnosTable = document.getElementById('turnosTable');
        const historialBtn = document.getElementById('historialBtn');
        const historialSection = document.getElementById('historialSection');
        const historialBody = document.getElementById('historialBody');
        let historialLoaded = false;

        // Generar días
        const today = new Date();
        for (let i = 0; i < 7; i++) {
            const day = new Date(today);
            day.setDate(today.getDate() + i);
            const dayButton = document.createElement('button');
            dayButton.classList.add('day-button');
            dayButton.textContent = day.toLocaleDateString('es-ES', { weekday: 'short', day: 'numeric' });
            dayButton.dataset.date = day.toISOString().split('T')[0];
            dayButton.addEventListener('click', () => selectDay(dayButton, dayButton.dataset.date));
            daysContainer.appendChild(dayButton);
        }

        function selectDay(button, date) {
            document.querySelectorAll('.day-button').forEach(btn => btn.classList.remove('selected'));
            button.classList.add('selected');
            loadTurnos(date);
        }

        function loadTurnos(date) {
            turnosTable.innerHTML = '<div class="text-center p-4"><div class="spinner-border text-warning"></div></div>';
            
            fetch(`/php/fetch_turnos_por_dia.php?date=${date}`)
                .then(response => response.json())
                .then(turnos => {
                    console.log('Turnos por día:', turnos);
                    let html = '';
                    if (turnos.length === 0) {
                        html = '<div class="empty-state"><i class="bi bi-calendar-x"></i><p>Aún no hay turnos agendados para este día</p></div>';
                    } else {
                        html = '<table class="table table-striped"><thead><tr><th>Usuario</th><th>Hora</th><th>Servicio</th><th>Subservicio</th><th>Seña</th><th>Estado</th><th>Acción</th></tr></thead><tbody>';
                        turnos.forEach(turno => {
                            html += `<tr>
                                <td><i class="bi bi-person-circle me-2"></i>${turno.user_name}</td>
                                <td><i class="bi bi-clock me-2"></i>${turno.hora}</td>
                                <td>${turno.category_key}</td>
                                <td>${turno.subservicio_name}</td>
                                <td><strong>$${turno.sena_pagada}</strong></td>
                                <td><span class="badge ${turno.status === 'pendiente' ? 'bg-warning' : turno.status === 'ocupado' ? 'bg-info' : 'bg-danger'}">${turno.status}</span></td>
                                <td>`;
                            if (turno.status !== 'cancelado') {
                                html += `<form method="POST" action="/php/cancelar_turno.php" style="display:inline;" onsubmit="return confirm('¿Está seguro de cancelar este turno?');">
                                    <input type="hidden" name="id_reserva" value="${turno.id_reserva}">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-x-circle me-1"></i>Cancelar</button>
                                </form>`;
                            } else {
                                html += '<span class="text-muted">Cancelado</span>';
                            }
                            html += `</td></tr>`;
                        });
                        html += '</tbody></table>';
                    }
                    turnosTable.innerHTML = html;
                }).catch(error => {
                    console.error('Error al cargar turnos:', error);
                    turnosTable.innerHTML = '<div class="empty-state text-danger"><i class="bi bi-exclamation-triangle"></i><p>Error al cargar los turnos</p></div>';
                });
        }

        historialBtn.addEventListener('click', () => {
            if (!historialLoaded) {
                historialBody.innerHTML = '<tr><td colspan="7" class="text-center"><div class="spinner-border text-warning"></div></td></tr>';
                fetch('/php/fetch_historial_turnos.php')
                    .then(response => response.json())
                    .then(turnos => {
                        console.log('Historial:', turnos);
                        let html = '';
                        if (turnos.length === 0) {
                            html = '<tr><td colspan="7" class="text-center">No hay registros en el historial</td></tr>';
                        } else {
                            turnos.forEach(turno => {
                                html += `<tr>
                                    <td><i class="bi bi-person-circle me-2"></i>${turno.user_name}</td>
                                    <td>${turno.fecha}</td>
                                    <td>${turno.hora}</td>
                                    <td>${turno.category_key}</td>
                                    <td>${turno.subservicio_name}</td>
                                    <td><strong>$${turno.sena_pagada}</strong></td>
                                    <td><span class="badge ${turno.status === 'completado' ? 'bg-success' : 'bg-secondary'}">${turno.status}</span></td>
                                </tr>`;
                            });
                        }
                        historialBody.innerHTML = html;
                        historialLoaded = true;
                    }).catch(error => {
                        console.error('Error al cargar historial:', error);
                        historialBody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error al cargar el historial</td></tr>';
                    });
            }
            
            const isVisible = historialSection.style.display === 'block';
            historialSection.style.display = isVisible ? 'none' : 'block';
            historialBtn.innerHTML = isVisible 
                ? '<i class="bi bi-clock-history me-2"></i>Ver Historial Completo'
                : '<i class="bi bi-eye-slash me-2"></i>Ocultar Historial';
        });

        // Seleccionar primer día automáticamente
        if (daysContainer.children.length > 0) {
            selectDay(daysContainer.children[0], daysContainer.children[0].dataset.date);
        }
    </script>
</body>
</html>