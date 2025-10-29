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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turnos Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .day-button.selected {
            background-color: #FFD700 !important;
            color: #000000 !important;
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a href="index_admin.php" class="text-white me-3"><i class="bi bi-arrow-left fs-4"></i> Volver al Inicio</a>
            <a class="navbar-brand" href="#">BarberShop Gold Style</a>
            <div class="boton-nav d-flex align-items-center">
                <span class="text-white me-2"><?php echo htmlspecialchars($_SESSION["nombre"] ?? 'Admin'); ?></span>
                <img src="https://via.placeholder.com/40" alt="Foto de Perfil" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                <a href="config_admin.php" class="text-white me-2"><i class="bi bi-gear fs-4"></i></a>
                <a href="?logout=1" class="text-white"><i class="bi bi-box-arrow-right fs-4"></i></a>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <h2>Turnos por Día</h2>
        <div class="days">
            <!-- Días generados JS -->
        </div>
        <div id="turnosTable" class="mt-4">
            <!-- Tabla turnos -->
        </div>
        <button id="historialBtn" class="btn btn-secondary mt-3">Ver Historial</button>
        <div id="historialSection" style="display: none;" class="mt-4">
            <h3>Historial de Turnos (No Pendientes)</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Servicio</th>
                        <th>Subservicio</th>
                        <th>Seña</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="historialBody">
                    <!-- Loaded JS -->
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const daysContainer = document.querySelector('.days');
        const turnosTable = document.getElementById('turnosTable');
        const historialBtn = document.getElementById('historialBtn');
        const historialSection = document.getElementById('historialSection');
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
            fetch(`/php/fetch_turnos_por_dia.php?date=${date}`)
                .then(response => response.json())
                .then(turnos => {
                    console.log('Turnos por día:', turnos);  // Debug
                    let html = '';
                    if (turnos.length === 0) {
                        html = '<p>Aun no se agendaron turnos</p>';
                    } else {
                        html = '<table class="table table-striped"><thead><tr><th>Usuario</th><th>Hora</th><th>Servicio</th><th>Subservicio</th><th>Seña</th><th>Status</th><th>Acción</th></tr></thead><tbody>';
                        turnos.forEach(turno => {
                            html += `<tr>
                                <td>${turno.user_name}</td>
                                <td>${turno.hora}</td>
                                <td>${turno.category_key}</td>
                                <td>${turno.subservicio_name}</td>
                                <td>$${turno.sena_pagada}</td>
                                <td>${turno.status}</td>
                                <td>`;
                            if (turno.status !== 'cancelado') {
                                html += `<form method="POST" action="/php/cancelar_turno.php" onsubmit="return confirm('¿Cancelar?');">
                                    <input type="hidden" name="id_reserva" value="${turno.id_reserva}">
                                    <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                                </form>`;
                            } else {
                                html += 'Cancelado';
                            }
                            html += `</td></tr>`;
                        });
                        html += '</tbody></table>';
                    }
                    turnosTable.innerHTML = html;
                }).catch(error => console.error('Error load turnos:', error));
        }

        historialBtn.addEventListener('click', () => {
            if (!historialLoaded) {
                fetch('/php/fetch_historial_turnos.php')
                    .then(response => response.json())
                    .then(turnos => {
                        console.log('Historial:', turnos);  // Debug
                        let html = '';
                        turnos.forEach(turno => {
                            html += `<tr>
                                <td>${turno.user_name}</td>
                                <td>${turno.fecha}</td>
                                <td>${turno.hora}</td>
                                <td>${turno.category_key}</td>
                                <td>${turno.subservicio_name}</td>
                                <td>$${turno.sena_pagada}</td>
                                <td>${turno.status}</td>
                            </tr>`;
                        });
                        historialBody.innerHTML = html;
                        historialLoaded = true;
                    }).catch(error => console.error('Error load historial:', error));
            }
            historialSection.style.display = historialSection.style.display === 'none' ? 'block' : 'none';
            historialBtn.textContent = historialSection.style.display === 'block' ? 'Ocultar Historial' : 'Ver Historial';
        });

        // Select first day
        if (daysContainer.children.length > 0) {
            selectDay(daysContainer.children[0], daysContainer.children[0].dataset.date);
        }
    </script>
</body>
</html>