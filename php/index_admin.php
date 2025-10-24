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
            <a class="navbar-brand" href="#">BarberShop Gold Style</a>
            <div class="boton-nav d-flex align-items-center">
                <span class="text-white me-2"><?php echo htmlspecialchars($_SESSION["nombre"] ?? 'Admin'); ?></span>
                <img src="https://via.placeholder.com/40" alt="Foto de Perfil" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                <a href="config_admin.php" class="text-white me-2"><i class="bi bi-gear fs-4"></i></a>
                <a href="?logout=1" class="text-white"><i class="bi bi-box-arrow-right fs-4"></i></a>
            </div>
        </div>
    </nav>

    <!-- PORTADA -->
    <div class="portada" style="background-image: url('uploads/<?= htmlspecialchars($portada['imagen'] ?? '') ?>');">
        <div class="portada-contenido">
            <h1><?= htmlspecialchars($portada['titulo'] ?? '') ?></h1>
            <div class="linea"></div>
            <p><?= htmlspecialchars($portada['descripcion'] ?? '') ?></p>
            <a href="sacar_turno.php" class="btn-transparente mt-3">Sacar turno</a><br>
            <button class="btn btn-warning mt-3"
                onclick='editarPortada(
                    <?= json_encode($portada["titulo"] ?? '') ?>, 
                    <?= json_encode($portada["descripcion"] ?? '') ?>, 
                    <?= json_encode($portada["imagen"] ?? '') ?>,
                    <?= json_encode($portada["id"] ?? '') ?>
                )'>
                Editar portada
            </button>
            <div class="texto">Leer más</div>
            <div class="contenedor-flechas">
            <div class="flecha"></div>
            <div class="flecha"></div>
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