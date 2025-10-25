<?php
session_start();
require_once '../conexion.php';

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['idusuario'])) {
    header("Location: /php/servicios/barba_publico.php");
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /html/registro.html?mode=login");
    exit;
}

$servicio = 'barba';  // Para este servicio

try {
    // Obtener intro desde BD
    $stmtIntro = $pdo->prepare("SELECT * FROM intro_servicios WHERE servicio = :servicio LIMIT 1");
    $stmtIntro->execute([':servicio' => $servicio]);
    $intro = $stmtIntro->fetch();

    if (!$intro) {
        $intro = ['titulo' => 'Título Default', 'descripcion' => 'Descripción default.'];
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
    $stmt = $pdo->prepare("SELECT * FROM barba ORDER BY id ASC");
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
    <link rel="stylesheet" href="/css/servicio.css">
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
    <!-- Portada -->
    <div class="cover" style="background-image: url('/php/uploads/<?php echo isset($portada['imagen']) ? htmlspecialchars($portada['imagen']) : 'https://via.placeholder.com/1920x1080'; ?>');">
        <div class="cover-overlay"></div>
        <div class="cover-content">
            <h1><?php echo isset($portada['titulo']) ? htmlspecialchars($portada['titulo']) : '¡Bienvenido a mi sitio!'; ?></h1>
            <p><?php echo isset($portada['descripcion']) ? htmlspecialchars($portada['descripcion']) : 'Descripción de la portada'; ?></p>
        </div>
        <div class="read-more">
            <span>Leer más</span>
            <div class="arrows">
                <i class="bi bi-chevron-down"></i>
                <i class="bi bi-chevron-down"></i>
            </div>
        </div>
    </div>
    <!-- Nuevo Contenedor Intro (sin botón editar) -->
    <div class="intro-container">
        <div class="intro-text">
            <h2><?php echo htmlspecialchars($intro['titulo']); ?></h2>
            <p><?php echo htmlspecialchars($intro['descripcion']); ?></p>
        </div>
    </div>

    <!-- Contenedores dinámicos (sin botones de editar) -->
    <?php foreach ($contenidos as $index => $contenido): ?>
        <div class="content-section">
            <div class="container-fluid">
                <div class="row align-items-center h-100">
                    <?php if ($index % 2 == 0): ?>
                        <div class="col-md-7 text-container">
                            <h2><?php echo htmlspecialchars($contenido['titulo']); ?></h2>
                            <p><?php echo htmlspecialchars($contenido['descripcion']); ?></p>
                            <p>Precio: $<?php echo number_format($contenido['precio'], 2); ?></p> <!-- Mostrar precio -->
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
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

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