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

// Fetch foto
$stmtFoto = $pdo->prepare("SELECT foto FROM usuarios WHERE idusuario = :id");
$stmtFoto->execute([':id' => $user_id]);
$user_foto = $stmtFoto->fetchColumn() ?: 'https://via.placeholder.com/40';

// Cargar categorías de servicios BD
$stmtCats = $pdo->query("SELECT * FROM servicios");
$categories = $stmtCats->fetchAll(PDO::FETCH_ASSOC);

// Fetch foto
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
    <title>Sacar Turnos</title>
    <link rel="stylesheet" href="/css/turno.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* MODALES */
.modal-content {
    background: linear-gradient(145deg, var(--black-secondary) 0%, var(--black-primary) 100%);
    border: 2px solid var(--gold-dark);
    color: var(--white);
    border-radius: 20px;
}

.modal-header {
    background: linear-gradient(135deg, var(--gold-primary) 0%, var(--gold-dark) 100%);
    border: none;
    border-radius: 18px 18px 0 0;
}

.modal-title {
    color: var(--black-primary);
    font-weight: 700;
    letter-spacing: 2px;
}

.modal-body {
    padding: 30px;
}

.modal-footer {
    border: none;
    background: var(--black-secondary);
    border-radius: 0 0 18px 18px;
}

.form-label {
    color: var(--gold-light);
    font-weight: 600;
}

.form-control {
    background: var(--black-light);
    border: 2px solid var(--gold-dark);
    color: var(--white);
    border-radius: 10px;
}

.form-control:focus {
    background: var(--black-secondary);
    border-color: var(--gold-primary);
    color: var(--white);
    box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
}

.btn-primary {
    background: linear-gradient(135deg, var(--gold-primary) 0%, var(--gold-dark) 100%) !important;
    border: none !important;
    color: var(--black-primary) !important;
    font-weight: 700;
    padding: 10px 25px;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold-primary) 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(212, 175, 55, 0.5);
}

.btn-close {
    filter: brightness(0) invert(1);
}

.dropdown-menu {
    background: var(--black-secondary);
    border: 2px solid var(--gold-dark);
    border-radius: 12px;
}

.dropdown-item {
    color: var(--gold-light);
    transition: all 0.3s ease;
}

.dropdown-item:hover {
    background: linear-gradient(135deg, var(--gold-dark) 0%, var(--gold-primary) 100%);
    color: var(--black-primary);
}
        .day-button.selected {
            background-color: #FFD700 !important;
            color: #000000 !important;
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


    <div class="container mt-5 pt-5">
        <h1>Sacar Turnos</h1>
        <div class="days">
            <!-- Días -->
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

    <!-- Modal Confirmación -->
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
                                <i class="bi bi-scissors"></i> <span id="turnoSubservicio"></span> (30 min)
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
    <!-- Modal Cambiar Foto -->
    <div class="modal fade" id="changePhotoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="guardar_foto.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="foto" class="form-label">Selecciona Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
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
        let selectedSubName = '';
        let selectedPrice = 0;

        // Generar días
        const today = new Date();
        for (let i = 0; i < 7; i++) {
            const day = new Date(today);
            day.setDate(today.getDate() + i);
            if (day.getDay() === 0) continue; // Excluir domingos
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
            // Fetch config por día
            fetch(`/php/fetch_config_por_dia.php?date=${date}`)
                .then(response => response.json())
                .then(config => {
                    console.log('Config por día:', config);  // Debug
                    if (config.error) {
                        alert('Error cargando config: ' + config.error);
                        return;
                    }
                    const times = generateTimes(config);
                    console.log('Times generated:', times);  // Debug

                    // Fetch disponibles
                    fetch(`/php/fetch_horarios_disponibles.php?date=${date}`)
                        .then(response => response.json())
                        .then(disponibles => {
                            console.log('Disponibles:', disponibles);  // Debug
                            times.forEach(time => {
                                const isDisponible = disponibles.includes(time);
                                const scheduleItem = document.createElement('div');
                                scheduleItem.classList.add('schedule-item');
                                if (isDisponible) {
                                    scheduleItem.innerHTML = `
                                        <span>${time}</span>
                                        <button class="agendar-button" onclick="openModal('${date}', '${time}')">Agendar</button>
                                    `;
                                } else {
                                    scheduleItem.innerHTML = `
                                        <span>${time}</span>
                                        <button class="btn btn-danger disabled">Agotado</button>
                                    `;
                                }
                                schedulesContainer.appendChild(scheduleItem);
                            });
                        }).catch(error => console.error('Error fetch disponibles:', error));
                }).catch(error => console.error('Error fetch config:', error));
        }

        function generateTimes(config) {
            const times = [];
            let current = new Date(`2000-01-01 ${config.manana_inicio}`);
            const manana_fin = new Date(`2000-01-01 ${config.manana_fin}`);
            while (current < manana_fin) {
                times.push(current.toTimeString().slice(0, 5));
                current = new Date(current.getTime() + config.intervalo * 60000);
            }
            current = new Date(`2000-01-01 ${config.tarde_inicio}`);
            const tarde_fin = new Date(`2000-01-01 ${config.tarde_fin}`);
            while (current < tarde_fin) {
                times.push(current.toTimeString().slice(0, 5));
                current = new Date(current.getTime() + config.intervalo * 60000);
            }
            return times;
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
                            option.dataset.name = srv.titulo || srv.name;
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
            selectedSubName = serviceSelect.selectedOptions[0].dataset.name;
            selectedPrice = serviceSelect.selectedOptions[0].dataset.price;
            if (selectedCategoryKey && selectedSubId) {
                closeModal();
                // Populate pretty modal
                document.getElementById('userName').textContent = '<?php echo htmlspecialchars($user_name); ?>';
                document.getElementById('turnoSubservicio').textContent = selectedSubName;
                document.getElementById('turnoFecha').textContent = `${currentDateTime.date} ⏰ ${currentDateTime.time}`;
                document.getElementById('turnoPrecio').textContent = `$${selectedPrice}`;
                document.getElementById('senaAmount').textContent = (selectedPrice / 2).toFixed(2);
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                confirmModal.show();

                // Abonar Seña
                // ... (resto del script igual)

document.getElementById('abonarSena').onclick = () => {
    fetch('crear_preferencia.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            user_id: <?php echo $user_id; ?>,
            date: currentDateTime.date,
            time: currentDateTime.time,
            category_key: selectedCategoryKey,
            sub_table: selectedCategoryKey,
            sub_id: selectedSubId,
            subservicio_name: selectedSubName,
            sena: (selectedPrice / 2).toFixed(2)
        })
    }).then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.init_point; // Redirigir a Mercado Pago
        } else {
            alert('Error: ' + data.error);
        }
    });
};

// ... (resto del script)
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