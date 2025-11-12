<?php
session_start();
require 'conexion.php';

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['idusuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index_principal.php");
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /html/registro.html?mode=login");
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
    <title>BarberShop Gold Style - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
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
            <a class="navbar-brand" href="#">💈Gold Style</a>
            <!-- Foto de perfil visible en mobile al lado del toggler -->
            <div class="user-info-mobile d-flex align-items-center d-md-none me-2">
                <img src="uploads/<?php echo htmlspecialchars($user_foto); ?>?t=<?php echo time(); ?>" alt="Foto de Perfil" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
            </div>
            <!-- Botón hamburguesa solo en mobile -->
            <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Elementos en desktop: nombre, foto con dropdown, config, logout -->
            <div class="user-info-desktop d-none d-md-flex align-items-center">
                <span class="text-white me-2"><?php echo htmlspecialchars($_SESSION["nombre"] ?? 'Admin'); ?></span>
                <div class="dropdown me-3">
                    <img src="uploads/<?php echo htmlspecialchars($user_foto); ?>?t=<?php echo time(); ?>" alt="Foto de Perfil" class="rounded-circle dropdown-toggle" style="width: 40px; height: 40px; object-fit: cover;" id="profileDropdownDesktop" data-bs-toggle="dropdown" aria-expanded="false">
                    <ul class="dropdown-menu" aria-labelledby="profileDropdownDesktop">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePhotoModal">Cambiar foto</a></li>
                    </ul>
                </div>
                <!-- Íconos en desktop -->
                <div class="desktop-nav d-flex align-items-center">
                    <a href="config_admin.php" class="text-white me-3"><i class="bi bi-gear fs-4"></i></a>
                    <a href="#" class="text-white logout-link"><i class="bi bi-box-arrow-right fs-4"></i></a>
                </div>
            </div>
            <!-- Menú collapse para mobile -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mobile-user-name d-md-none">
                        <span class="nav-link"><?php echo htmlspecialchars($_SESSION["nombre"] ?? 'Admin'); ?></span>
                    </li>
                    <li class="nav-item mobile-change-photo d-md-none">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#changePhotoModal">Cambiar foto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-redirect" href="config_admin.php"><i class="bi bi-gear me-2"></i>Configuración</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-link" href="#"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- PORTADA (ahora con estilos de index_cliente.php) -->
    <div class="cover" style="background-image: url('uploads/<?= htmlspecialchars($portada['imagen'] ?? '') ?>');">
        <div class="cover-overlay"></div>
        <div class="cover-content">
            <h1><?= htmlspecialchars($portada['titulo'] ?? '') ?></h1>
            <div class="linea"></div>
            <p><?= htmlspecialchars($portada['descripcion'] ?? '') ?></p>
            <!-- Mantengo los botones y funciones del admin -->
            <a href="turnos_admin.php" class="btn-transparente mt-3">Turnos</a>
            <button class="btn btn-warning mt-3"
                onclick='editarPortada(
                    <?= json_encode($portada["titulo"] ?? '') ?>, 
                    <?= json_encode($portada["descripcion"] ?? '') ?>, 
                    <?= json_encode($portada["imagen"] ?? '') ?>,
                    <?= json_encode($portada["id"] ?? '') ?>
                )'>
                Editar portada
            </button>
        </div>
        <div class="read-more">
            <span>Leer más</span>
            <div class="arrows">
                <i class="bi bi-chevron-down"></i>
                <i class="bi bi-chevron-down"></i>
            </div>
        </div>
    </div>

    <!-- SECCIONES -->
    <div class="container-fluid p-0">
        <div class="row g-0">
            <?php foreach ($servicios as $seccion => $servicio): ?>
                <?php 
                // Para admins, redirigir a admin/{nombre}_admin.php
                $base_name = str_replace('.php', '', $servicio['link']);
                $link = 'admin/' . $base_name . '_admin.php';
                ?>
                <div class="col-<?= in_array($seccion, ['section-1', 'section-4', 'section-5']) ? '7' : '5' ?> p-0">
                    <div class="section <?= $seccion ?>" 
                         style="background-image: url('uploads/<?= htmlspecialchars($servicio['imagen']) ?>'); 
                                background-size: cover; background-position: center; position: relative;">

                        <!-- Contenido -->
                        <div class="contenido-seccion">
                            <h2 class="titulo-sec"><?= htmlspecialchars($servicio['titulo']) ?></h2>
                            <p class="parr"><?= htmlspecialchars($servicio['descripcion']) ?></p>
                            <button class="btn btn-warning mt-2"
                                onclick='editarServicio(
                                    <?= json_encode($seccion) ?>, 
                                    <?= json_encode($servicio["titulo"]) ?>, 
                                    <?= json_encode($servicio["descripcion"]) ?>, 
                                    <?= json_encode($servicio["imagen"]) ?>
                                )'>
                                Editar
                            </button>
                        </div>

                        <!-- Enlace invisible sobre toda la sección (movido después del contenido para que esté encima) -->
                        <a href="<?= htmlspecialchars($link) ?>" 
                           style="position: absolute; top:0; left:0; width:100%; height:100%; z-index:2;"></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- MODAL EDITAR PORTADA -->
    <div class="modal fade" id="modalEditarPortada" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="guardar_portada.php" enctype="multipart/form-data" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Editar Portada</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="portadaIdInput">
            <input type="hidden" name="imagen_actual" id="portadaImagenActual">
              <div class="mb-3">
                  <label>Título</label>
                  <input type="text" class="form-control" name="titulo" id="portadaTituloInput" required>
              </div>
              <div class="mb-3">
                  <label>Descripción</label>
                  <textarea class="form-control" name="descripcion" id="portadaDescripcionInput" required></textarea>
              </div>
              <div class="mb-3">
                  <label>Imagen actual</label><br>
                  <small id="portadaRutaActual" class="text-muted"></small>
                  <img id="portadaImagenPreview" src="" alt="Vista previa de la imagen" class="img-fluid mb-2" style="max-height: 150px;">
                  <input type="file" class="form-control" name="imagen">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>

    <!-- MODAL EDITAR SERVICIO -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="guardar_servicio.php" enctype="multipart/form-data" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Editar Servicio</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <input type="hidden" name="seccion" id="seccionInput">
              <div class="mb-3">
                  <label>Título</label>
                  <input type="text" class="form-control" name="titulo" id="tituloInput" required>
              </div>
              <div class="mb-3">
                  <label>Descripción</label>
                  <textarea class="form-control" name="descripcion" id="descripcionInput" required></textarea>
              </div>
              <div class="mb-3">
                  <label>Imagen actual</label><br>
                  <img id="imagenPreview" src="" alt="Imagen" class="img-fluid mb-2" style="max-height: 150px;">
                  <input type="file" class="form-control" name="imagen">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
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

    <script>
        function editarServicio(seccion, titulo, descripcion, imagen) {
            document.getElementById('seccionInput').value = seccion;
            document.getElementById('tituloInput').value = titulo;
            document.getElementById('descripcionInput').value = descripcion;
            document.getElementById('imagenPreview').src = 'uploads/' + (imagen || '');
            new bootstrap.Modal(document.getElementById('modalEditar')).show();
        }

        function editarPortada(titulo, descripcion, imagen, id) {
            document.getElementById('portadaTituloInput').value = titulo;
            document.getElementById('portadaDescripcionInput').value = descripcion;
            document.getElementById('portadaImagenPreview').src = imagen ? 'uploads/' + imagen : '';
            document.getElementById('portadaImagenActual').value = imagen || '';
            document.getElementById('portadaIdInput').value = id;
            document.getElementById('portadaRutaActual').innerText = imagen ? 'Ruta actual: uploads/' + imagen : 'No hay imagen actual';
            new bootstrap.Modal(document.getElementById('modalEditarPortada')).show();
        }
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

        // Para links de redirección en mobile (como Configuración)
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