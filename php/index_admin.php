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
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">💈Gold Style</a>
            <div class="boton-nav d-flex align-items-center">
                <span class="text-white me-2"><?php echo htmlspecialchars($_SESSION["nombre"] ?? 'Admin'); ?></span>
                <div class="dropdown">
                    <img src="uploads/<?php echo htmlspecialchars($user_foto); ?>?t=<?php echo time(); ?>" alt="Foto de Perfil" class="rounded-circle me-2 dropdown-toggle" style="width: 40px; height: 40px; object-fit: cover;" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePhotoModal">Cambiar foto</a></li>
                    </ul>
                </div>
                <a href="config_admin.php" class="text-white me-2"><i class="bi bi-gear fs-4"></i></a>
                <a href="?logout=1" class="text-white"><i class="bi bi-box-arrow-right fs-4"></i></a>
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

                        <!-- Enlace invisible sobre toda la sección -->
                        <a href="<?= htmlspecialchars($link) ?>" 
                           style="position: absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></a>

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
                    <li><a href="#.php">Cortes</a></li>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

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
    </script>
</body>
</html>