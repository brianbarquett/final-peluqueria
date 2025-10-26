<?php
session_start();
require '../php/conexion.php';  // Ajusta ruta

// Si no logueado, redirigir
if (!isset($_SESSION['idusuario'])) {
    header("Location: /html/registro.html?mode=login");
    exit;
}

$user_id = $_SESSION['idusuario'];
$user_name = $_SESSION['nombre'];

// Cargar categorías de servicios BD
$stmtCats = $pdo->query("SELECT * FROM servicios");
$categories = $stmtCats->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sacar Turnos</title>
    <link rel="stylesheet" href="/css/turno.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Sacar Turnos</h1>
        <div class="days">
            <!-- Días generados JS -->
        </div>
        <div class="schedules">
            <!-- Horarios -->
        </div>
    </div>

    <div id="modal">
        <h2>Selecciona un Servicio</h2>
        <select id="category">
            <option value="">Selecciona un servicio</option>
            <?php foreach ($categories as $cat): 
                $key = str_replace(['servicios/', '.php'], '', $cat['link']);
            ?>
                <option value="<?php echo $key; ?>"><?php echo htmlspecialchars($cat['titulo']); ?></option>
            <?php endforeach; ?>
        </select>
        <select id="service" disabled>
            <option value="">Selecciona un sub-servicio</option>
        </select>
        <button id="confirmButton">Confirmar</button>
    </div>

    <div id="overlay"></div>

    <!-- Modal Confirmación (Pretty like image) -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">TURNOS A RESERVAR (1)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="turnoTabs">
                        <li class="nav-item">
                            <button class="nav-link active" id="turno1-tab" data-bs-toggle="tab" data-bs-target="#turno1" type="button">Turno 1</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="turnoTabContent">
                        <div class="tab-pane fade show active" id="turno1">
                            <div class="user-info mt-3">
                                <i class="bi bi-person-circle"></i> <span id="userName"><?php echo htmlspecialchars($user_name); ?></span>
                            </div>
                            <div class="service-info">
                                <i class="bi bi-scissors"></i> <span id="turnoSubservicio"></span> (45 min)
                            </div>
                            <div class="date-info">
                                <i class="bi bi-calendar-event"></i> <span id="turnoFecha"></span>
                            </div>
                            <div class="address-info">
                                <i class="bi bi-geo-alt"></i> Calle 46 68, La Plata piso 2
                            </div>
                            <div class="discount-info">
                                <input type="text" placeholder="Tengo código de descuento" class="form-control">
                                <button class="btn btn-danger btn-sm remove-discount"><i class="bi bi-trash"></i></button>
                            </div>
                            <div class="total-info mt-3">
                                <strong>Total:</strong> <span id="turnoPrecio"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="abonarSena" class="btn btn-primary w-100">ABONAR SEÑA ($<span id="senaAmount"></span>)</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const daysContainer = document.querySelector('.days');
        const schedulesContainer = document.querySelector('.schedules');
        const modal = document.getElementById('modal');
        const overlay = document.getElementById('overlay');
        const categorySelect = document.getElementById('category');
        const serviceSelect = document.getElementById('service');
        const confirmButton = document.getElementById('confirmButton');
        let selectedDate = null;
        let currentDateTime = null;
        let selectedCategoryKey = null;
        let selectedSubId = null;
        let selectedPrice = 0;

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
            selectedDate = date;
            loadSchedules(date);
        }

        function loadSchedules(date) {
            schedulesContainer.innerHTML = '';
            const times = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
            times.forEach(time => {
                const scheduleItem = document.createElement('div');
                scheduleItem.classList.add('schedule-item');
                scheduleItem.innerHTML = `
                    <span>${time}</span>
                    <button class="agendar-button" onclick="openModal('${date}', '${time}')">Agendar</button>
                `;
                schedulesContainer.appendChild(scheduleItem);
            });
        }

        // Cambio categoría: Fetch subservicios
        categorySelect.addEventListener('change', (e) => {
            selectedCategoryKey = e.target.value;
            serviceSelect.innerHTML = '<option value="">Selecciona un sub-servicio</option>';
            serviceSelect.disabled = !selectedCategoryKey;
            if (selectedCategoryKey) {
                fetch(`/php/fetch_subservicios.php?category_key=${selectedCategoryKey}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(srv => {
                            const option = document.createElement('option');
                            option.value = srv.id;
                            option.textContent = `${srv.titulo || srv.name} - $${srv.precio}`;
                            option.dataset.price = srv.precio;
                            serviceSelect.appendChild(option);
                        });
                    });
            }
        });

        function openModal(date, time) {
            currentDateTime = { date, time };
            categorySelect.value = '';
            serviceSelect.value = '';
            serviceSelect.disabled = true;
            modal.style.display = 'block';
            overlay.style.display = 'block';
        }

        function closeModal() {
            modal.style.display = 'none';
            overlay.style.display = 'none';
        }

        confirmButton.addEventListener('click', () => {
            selectedSubId = serviceSelect.value;
            selectedPrice = serviceSelect.selectedOptions[0].dataset.price;
            if (selectedCategoryKey && selectedSubId) {
                closeModal();
                // Populate pretty modal
                document.getElementById('userName').textContent = '<?php echo htmlspecialchars($user_name); ?>';
                document.getElementById('turnoSubservicio').textContent = serviceSelect.selectedOptions[0].textContent.split(' - ')[0];
                document.getElementById('turnoFecha').textContent = `${currentDateTime.date} ⏰ ${currentDateTime.time}`;
                document.getElementById('turnoPrecio').textContent = `$${selectedPrice}`;
                document.getElementById('senaAmount').textContent = (selectedPrice / 2).toFixed(2);
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                confirmModal.show();

                // Abonar Seña
                document.getElementById('abonarSena').onclick = () => {
                    fetch('/php/guardar_turno.php', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({
                            user_id: <?php echo $user_id; ?>,
                            date: currentDateTime.date,
                            time: currentDateTime.time,
                            category_key: selectedCategoryKey,
                            sub_table: selectedCategoryKey,
                            sub_id: selectedSubId,
                            sena: (selectedPrice / 2).toFixed(2)
                        })
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Turno reservado!');
                            confirmModal.hide();
                            loadSchedules(selectedDate);
                        } else {
                            alert('Error: ' + data.error);
                        }
                    });
                };
            } else {
                alert('Selecciona servicio y sub-servicio.');
            }
        });

        overlay.addEventListener('click', closeModal);

        if (daysContainer.children.length > 0) {
            selectDay(daysContainer.children[0], daysContainer.children[0].dataset.date);
        }
    </script>
</body>
</html>