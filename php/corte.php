<?php
require_once 'conexion.php';

try {
    // Obtener datos de la portada
    $stmt = $pdo->prepare("SELECT * FROM portada WHERE id = 1");
    $stmt->execute();
    $portada = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener datos de los contenedores
    $stmt = $pdo->prepare("SELECT * FROM contenidos ORDER BY id ASC");
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
    <title>Portada Responsiva con Contenedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/corte.css">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">BarberShop Gold Style</a>
            <div class="boton-nav">
                <a href="../html/login.html" class="btn btn-outline-light">Iniciar sesión</a>
            </div>
        </div>
    </nav>
    <!-- Portada -->
    <div class="cover" style="background-image: url('<?php echo isset($portada['imagen']) ? htmlspecialchars($portada['imagen']) : 'https://via.placeholder.com/1920x1080'; ?>');">
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

    <!-- Contenedores dinámicos -->
    <?php foreach ($contenidos as $index => $contenido): ?>
        <div class="content-section">
            <div class="container-fluid">
                <div class="row align-items-center h-100">
                    <?php if ($index % 2 == 0): ?>
                        <div class="col-md-7 text-container">
                            <h2><?php echo htmlspecialchars($contenido['titulo']); ?></h2>
                            <p><?php echo htmlspecialchars($contenido['descripcion']); ?></p>
                            <button class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $contenido['id']; ?>">Editar</button>
                        </div>
                        <div class="col-md-5">
                            <img src="<?php echo $contenido['imagen'] ? htmlspecialchars($contenido['imagen']) : 'https://via.placeholder.com/500'; ?>" class="content-image" alt="Imagen <?php echo $contenido['id']; ?>">
                        </div>
                    <?php else: ?>
                        <div class="col-md-5 order-md-1 order-2">
                            <img src="<?php echo $contenido['imagen'] ? htmlspecialchars($contenido['imagen']) : 'https://via.placeholder.com/500'; ?>" class="content-image" alt="Imagen <?php echo $contenido['id']; ?>">
                        </div>
                        <div class="col-md-7 order-md-2 order-1 text-container">
                            <h2><?php echo htmlspecialchars($contenido['titulo']); ?></h2>
                            <p><?php echo htmlspecialchars($contenido['descripcion']); ?></p>
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
                        <form action="guardar_corte.php" method="POST" enctype="multipart/form-data">
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
                    <form action="guardar.php" method="POST" enctype="multipart/form-data">
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
                            <label for="imagenNuevo" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="imagenNuevo" name="imagen" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar Portada -->
    <div class="modal fade" id="editCoverModal" tabindex="-1" aria-labelledby="editCoverModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCoverModalLabel">Editar Portada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="guardar_portada.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="1">
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