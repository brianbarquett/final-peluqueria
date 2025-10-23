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

// Manejar solicitud AJAX para cargar horarios
if (isset($_POST['action']) && $_POST['action'] === 'cargar_horarios') {
    $selected_date = $_POST['date'];
    $horarios = [
        '08:00:00', '08:30:00', '09:00:00', '09:30:00', '10:00:00', '10:30:00', '11:00:00', '11:30:00',
        '17:00:00', '17:30:00', '18:00:00', '18:30:00', '19:00:00', '19:30:00', '20:00:00', '20:30:00'
    ];

    $html = '';
    foreach ($horarios as $hora) {
        $stmt = $pdo->prepare("SELECT * FROM reservas WHERE fecha = ? AND hora = ?");
        $stmt->execute([$selected_date, $hora]);
        $reservado = $stmt->rowCount() > 0;

        $status = $reservado ? 'reservado' : 'disponible';
        $color = $reservado ? 'text-danger' : 'text-success';

        $html .= "<div class='horario-card d-flex justify-content-between align-items-center'>
                    <span>{$hora}</span>
                    <span class='status {$color}'>".ucfirst($status)."</span>
                    <button class='btn btn-primary reservar-btn' data-hora='{$hora}' ".($reservado ? 'disabled' : '').">Reservar</button>
                  </div>";
    }
    echo $html;
    exit;
}

// Manejar solicitud AJAX para reservar turno
if (isset($_POST['action']) && $_POST['action'] === 'reservar') {
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $idusuario = $_SESSION['idusuario'];

    // Verificar si está disponible
    $stmt = $pdo->prepare("SELECT * FROM reservas WHERE fecha = ? AND hora = ?");
    $stmt->execute([$fecha, $hora]);
    if ($stmt->rowCount() == 0) {
        // Asumimos que la tabla 'reservas' tiene columnas: id (auto), fecha, hora, idusuario
        // Si no existe idusuario, modifica la BD: ALTER TABLE reservas ADD COLUMN idusuario INT NOT NULL;
        $insert = $pdo->prepare("INSERT INTO reservas (fecha, hora, idusuario) VALUES (?, ?, ?)");
        if ($insert->execute([$fecha, $hora, $idusuario])) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo 'error';
    }
    exit;
}

// Obtener los servicios desde la base de datos
$stmt = $pdo->query("SELECT * FROM servicios");
$servicios = [];
while ($row = $stmt->fetch()) {
    $servicios[$row['seccion']] = $row;
}

// Obtener los datos de la portada
$stmtPortada = $pdo->query("SELECT * FROM portada LIMIT 1");
$portada = $stmtPortada->fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sacar Turno - BarberShop Gold Style</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/sacar_turno.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">BarberShop Gold Style</a>
            <div class="boton-nav d-flex align-items-center">
                <span class="text-white me-2"><?php echo htmlspecialchars($_SESSION["nombre"] ?? 'Usuario'); ?></span>
                <img src="https://via.placeholder.com/40" alt="Foto de Perfil" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                <a href="config_cliente.php" class="text-white me-2"><i class="bi bi-gear fs-4"></i></a>
                <a href="?logout=1" class="text-white"><i class="bi bi-box-arrow-right fs-4"></i></a>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <h1 class="text-center my-4">Sacar Turno</h1>
        
        <!-- Contenedor de días -->
        <div class="days-container d-flex justify-content-center mb-4">
            <?php
            $today = new DateTime();
            $dias_es = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
            for ($i = 0; $i < 7; $i++) {
                $date = (clone $today)->add(new DateInterval("P{$i}D"));
                $dayNum = $date->format('w');
                $dayName = $dias_es[$dayNum];
                $dayDate = $date->format('Y-m-d');
                $class = ($i == 0) ? 'day-card active' : 'day-card';
                echo "<div class='{$class}' data-date='{$dayDate}'>
                        <div class='day-name'>{$dayName}</div>
                        <div class='day-date'>{$date->format('d/m')}</div>
                      </div>";
            }
            ?>
        </div>
        
        <!-- Contenedor de horarios con recuadro bonito -->
        <div class="content-card">
            <div class="horarios-container" id="horarios-container">
                <?php
                // Horarios iniciales para el día actual
                $current_date = date('Y-m-d');
                $horarios = [
                    '08:00:00', '08:30:00', '09:00:00', '09:30:00', '10:00:00', '10:30:00', '11:00:00', '11:30:00',
                    '17:00:00', '17:30:00', '18:00:00', '18:30:00', '19:00:00', '19:30:00', '20:00:00', '20:30:00'
                ];
                foreach ($horarios as $hora) {
                    $stmt = $pdo->prepare("SELECT * FROM reservas WHERE fecha = ? AND hora = ?");
                    $stmt->execute([$current_date, $hora]);
                    $reservado = $stmt->rowCount() > 0;
                    
                    $status = $reservado ? 'reservado' : 'disponible';
                    $color = $reservado ? 'text-danger' : 'text-success';
                    
                    echo "<div class='horario-card d-flex justify-content-between align-items-center'>
                            <span>{$hora}</span>
                            <span class='status {$color}'>".ucfirst($status)."</span>
                            <button class='btn btn-primary reservar-btn' data-hora='{$hora}' ".($reservado ? 'disabled' : '').">Reservar</button>
                          </div>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JS para seleccionar día y cargar horarios vía AJAX
        const days = document.querySelectorAll('.day-card');
        days.forEach(day => {
            day.addEventListener('click', () => {
                days.forEach(d => d.classList.remove('active'));
                day.classList.add('active');
                const selectedDate = day.dataset.date;
                
                // AJAX para cargar horarios
                fetch(window.location.href, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=cargar_horarios&date=${selectedDate}`
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('horarios-container').innerHTML = data;
                    attachReservarListeners(); // Adjuntar listeners después de cargar
                })
                .catch(error => console.error('Error:', error));
            });
        });

        // Función para adjuntar listeners a botones de reservar (delegación de eventos)
        function attachReservarListeners() {
            const horariosContainer = document.getElementById('horarios-container');
            horariosContainer.addEventListener('click', (event) => {
                if (event.target.classList.contains('reservar-btn') && !event.target.disabled) {
                    const btn = event.target;
                    const hora = btn.dataset.hora;
                    const fecha = document.querySelector('.day-card.active').dataset.date;
                    
                    // AJAX para reservar
                    fetch(window.location.href, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `action=reservar&fecha=${fecha}&hora=${hora}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            btn.disabled = true;
                            btn.textContent = 'Reservado';
                            const statusSpan = btn.parentElement.querySelector('.status');
                            statusSpan.classList.remove('text-success');
                            statusSpan.classList.add('text-danger');
                            statusSpan.textContent = 'Reservado';
                            alert('Turno reservado exitosamente!');
                        } else {
                            alert('Error al reservar el turno. Posiblemente ya está reservado.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
        }

        // Adjuntar listeners iniciales
        attachReservarListeners();
    </script>
</body>
</html>