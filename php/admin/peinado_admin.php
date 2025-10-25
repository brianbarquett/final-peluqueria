<?php
session_start();
require_once '../conexion.php';

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['idusuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../index_principal.php");
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /html/registro.html?mode=login");
    exit;
}

$servicio = 'peinado';  // Para este archivo; cambiar en otros (ej: 'tintura')

try {
    // Obtener intro desde BD
    $stmtIntro = $pdo->prepare("SELECT * FROM intro_servicios WHERE servicio = :servicio LIMIT 1");
    $stmtIntro->execute([':servicio' => $servicio]);
    $intro = $stmtIntro->fetch();

    if (!$intro) {
        $intro = ['id' => null, 'titulo' => 'Título Default', 'descripcion' => 'Descripción default.'];
    }

    // Obtener datos de la portada (segunda fila: id=2 o la segunda disponible)
    $stmtPortada = $pdo->query("SELECT * FROM portada ORDER BY id ASC LIMIT 1 OFFSET 1");
    $portada = $stmtPortada->fetch();

    // Si no existe, usa valores predeterminados
    if (!$portada) {
        $portada = [
            'titulo' => 'Portada Predeterminada para Servicios',
            'descripcion' => 'Descripción temporal hasta que se cree id=2 en la DB.',
            'imagen' => 'https://via.placeholder.com/1920x1080'  // Placeholder temporal
        ];
    }

    // Obtener datos de los contenedores (incluyendo precio)
    $stmt = $pdo->prepare("SELECT * FROM peinado ORDER BY id ASC");  // Cambiar tabla por servicio si aplica (ej: barba para barba_admin.php)
    $stmt->execute();
    $contenidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portada Responsiva con Contenedores - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/servicio.css">
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
    <!-- Portada -->
    <div class="cover" style="background-image: url('/php/uploads/<?php echo isset($portada['imagen']) ? htmlspecialchars($portada['imagen']) : 'https://via.placeholder.com/1920x1080'; ?>');">
        <div class="cover-overlay"></div>
        <div class="cover-content">
            <h1><?php echo isset($portada['titulo']) ? htmlspecialchars($portada['titulo']) : '¡Bienvenido a mi sitio!'; ?></h1>
            <p><?php echo isset($portada['descripcion']) ? htmlspecialchars($portada['descripcion']) : 'Descripción de la portada'; ?></p>
        </div>
        <button class="btn btn-light edit-cover-btn" data-bs-toggle="modal" data-bs-target="#editCoverModal">Editar Portada</button>
        <div class="read-more">
            <span>Leer más</span>
            <div class="arrows">
                <i class="bi bi-chevron-down"></i>
                <i class="bi bi-chevron-down"></i>
            </div>
        </div>
    </div>

    <!-- Nuevo Contenedor Intro (debajo de portada) -->
    <div class="intro-container">
        <div class="intro-text">
            <h2><?php echo htmlspecialchars($intro['titulo']); ?></h2>
            <p><?php echo htmlspecialchars($intro['descripcion']); ?></p>
        </div>
        <button class="btn btn-light edit-intro-btn" data-bs-toggle="modal" data-bs-target="#editIntroModal">Editar Intro</button>
    </div>

    <!-- Contenedores dinámicos (resto igual) -->
    <?php foreach ($contenidos as $index => $contenido): ?>
        <!-- ... (código de contenedores existente) ... -->
    <?php endforeach; ?>

    <!-- ... (botón agregar nuevo, modales existentes) ... -->

    <!-- Nuevo Modal para Editar Intro -->
    <div class="modal fade" id="editIntroModal" tabindex="-1" aria-labelledby="editIntroModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editIntroModalLabel">Editar Intro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/php/guardar_intro.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $intro['id']; ?>">
                        <input type="hidden" name="servicio" value="<?php echo $servicio; ?>">
                        <div class="mb-3">
                            <label for="tituloIntro" class="form-label">Título</label>
                            <input type="text" class="form-control" id="tituloIntro" name="titulo" value="<?php echo htmlspecialchars($intro['titulo']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcionIntro" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcionIntro" name="descripcion" required><?php echo htmlspecialchars($intro['descripcion']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenedores dinámicos -->
    <?php foreach ($contenidos as $index => $contenido): ?>
        <div class="content-section">
            <div class="container-fluid">
                <div class="row align-items-center h-100">
                    <?php if ($index % 2 == 0): ?>
                        <div class="col-md-7 text-container">
                            <h2><?php echo htmlspecialchars($contenido['titulo']); ?></h2>
                            <p><?php echo htmlspecialchars($contenido['descripcion']); ?></p>
                            <p>Precio: $<?php echo number_format($contenido['precio'], 2); ?></p> <!-- Mostrar precio -->
                            <button class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $contenido['id']; ?>">Editar</button>
                        </div>
                        <div class="col-md-5">
                            <img src="/php/<?php echo $contenido['imagen'] ? htmlspecialchars($contenido['imagen']) : 'https://via.placeholder.com/500'; ?>" class="content-image" alt="Imagen <?php echo $contenido['id']; ?>">
                        </div>
                    <?php else: ?>
                        <div class="col-md-5 order-md-1 order-2">
                            <img src="/php/<?php echo $contenido['imagen'] ? htmlspecialchars($contenido['imagen']) : 'https://via.placeholder.com/500'; ?>" class="content-image" alt="Imagen <?php echo $contenido['id']; ?>">
                        </div>
                        <div class="col-md-7 order-md-2 order-1 text-container">
                            <h2><?php echo htmlspecialchars($contenido['titulo']); ?></h2>
                            <p><?php echo htmlspecialchars($contenido['descripcion']); ?></p>
                            <p>Precio: $<?php echo number_format($contenido['precio'], 2); ?></p> <!-- Mostrar precio -->
                            <button class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $contenido['id']; ?>">Editar</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Modal para editar contenedor -->
        <div class="modal fade" id="editModal<?php echo $contenido['id']; ?>" tabindex="-1" aria-labelledby="editModal<?php echo $contenido['id']; ?>Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal<?php echo $contenido['id']; ?>Label">Editar Sección <?php echo $contenido['id']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/php/guardar_peinado.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $contenido['id']; ?>">
                            <div class="mb-3">
                                <label for="titulo<?php echo $contenido['id']; ?>" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo<?php echo $contenido['id']; ?>" name="titulo" value="<?php echo htmlspecialchars($contenido['titulo']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion<?php echo $contenido['id']; ?>" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion<?php echo $contenido['id']; ?>" name="descripcion" required><?php echo htmlspecialchars($contenido['descripcion']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="precio<?php echo $contenido['id']; ?>" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="precio<?php echo $contenido['id']; ?>" name="precio" step="0.01" value="<?php echo $contenido['precio']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="imagen<?php echo $contenido['id']; ?>" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="imagen<?php echo $contenido['id']; ?>" name="imagen" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Botón Agregar más -->
    <div class="add-btn-section">
        <button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#addModal">Agregar más</button>
    </div>

    <!-- Modal para agregar nuevo contenedor -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Agregar Nueva Sección</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/php/guardar_corte.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="0">
                        <div class="mb-3">
                            <label for="tituloNuevo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="tituloNuevo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcionNuevo" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcionNuevo" name="descripcion" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precioNuevo" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="precioNuevo" name="precio" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="imagenNuevo" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="imagenNuevo" name="imagen" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar Portada (usa id=2) -->
    <div class="modal fade" id="editCoverModal" tabindex="-1" aria-labelledby="editCoverModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCoverModalLabel">Editar Portada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/php/guardar_portada.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="2">
                        <div class="mb-3">
                            <label for="tituloCover" class="form-label">Título</label>
                            <input type="text" class="form-control" id="tituloCover" name="titulo" value="<?php echo isset($portada['titulo']) ? htmlspecialchars($portada['titulo']) : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcionCover" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcionCover" name="descripcion" required><?php echo isset($portada['descripcion']) ? htmlspecialchars($portada['descripcion']) : ''; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="imagenCover" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="imagenCover" name="imagen" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sections = document.querySelectorAll('.content-section');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.2 });

        sections.forEach(section => observer.observe(section));

        const coverContent = document.querySelector('.cover-content');
        const readMore = document.querySelector('.read-more');
        const cover = document.querySelector('.cover');
        const maxTranslate = 100;

        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY;
            const windowHeight = window.innerHeight;
            const coverHeight = cover.offsetHeight;
            const maxScroll = coverHeight * 0.8;

            if (scrollY <= maxScroll) {
                const contentOpacity = 1 - (scrollY / maxScroll);
                const contentTranslate = Math.min(scrollY * 0.5, maxTranslate);
                coverContent.style.opacity = contentOpacity > 0 ? contentOpacity : 0;
                coverContent.style.transform = `translateY(${contentTranslate}px)`;

                const readMoreOpacity = 1 - (scrollY / maxScroll);
                const readMoreTranslate = Math.min(scrollY * 0.3, maxTranslate);
                readMore.style.opacity = readMoreOpacity > 0 ? readMoreOpacity : 0;
                readMore.style.transform = `translateY(${readMoreTranslate}px)`;
            } else {
                coverContent.style.opacity = 0;
                coverContent.style.transform = `translateY(${maxTranslate}px)`;
                readMore.style.opacity = 0;
                readMore.style.transform = `translateY(${maxTranslate}px)`;
            }
        });
    </script>
</body>
</html>