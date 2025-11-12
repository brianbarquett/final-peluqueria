<?php require 'php/conexion.php'; ?>

<?php
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
    <title>BarberShop Gold Style</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Ruta corregida al CSS -->
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">💈Gold Style</a>
            <div class="boton-nav">
                <!-- Ruta corregida al login -->
                <a href="../html/registro.html?mode=login" class="btn btn-outline-light">Iniciar sesión</a>
            </div>
        </div>
    </nav>

    <!-- PORTADA (adaptada como cover de servicio.css) -->
    <div class="cover" style="background-image: url('php/uploads/<?= htmlspecialchars($portada['imagen']) ?>');">
        <div class="cover-overlay"></div>
        <div class="cover-content">
            <h1><?= htmlspecialchars($portada['titulo']) ?></h1>
            <div class="linea"></div>
            <p><?= htmlspecialchars($portada['descripcion']) ?></p>
            <a href="php/turno.php" class="btn-transparente mt-3">Sacar turno</a>
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
                // Para no logueados, redirigir a php/servicios/{nombre}_publico.php
                $nombre = str_replace(['servicios/', '.php'], '', $servicio['link']);
                $link = 'php/servicios/' . $nombre . '_publico.php';
                ?>
                <div class="col-<?= in_array($seccion, ['section-1', 'section-4', 'section-5']) ? '7' : '5' ?> p-0">
                    <div class="section <?= $seccion ?>" 
                         style="background-image: url('php/uploads/<?= htmlspecialchars($servicio['imagen']) ?>'); 
                                background-size: cover; background-position: center; position: relative;">

                        <!-- Contenido -->
                        <div class="contenido-seccion">
                            <h2 class="titulo-sec"><?= htmlspecialchars($servicio['titulo']) ?></h2>
                            <p class="parr"><?= htmlspecialchars($servicio['descripcion']) ?></p>
                        </div>

                        <!-- Enlace invisible sobre toda la sección (movido después del contenido para que esté encima) -->
                        <a href="<?= htmlspecialchars($link) ?>" 
                           style="position: absolute; top:0; left:0; width:100%; height:100%; z-index:2;"></a>
                    </div>
                </div>
            <?php endforeach; ?>
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
                <li><a href="#">Cortes</a></li>
                <li><a href="#">Barbas</a></li>
                <li><a href="#">Productos</a></li>
                <li><a href="#">Servicios Completos</a></li>
                <li><a href="#">Reservar Turno</a></li>
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
                    Calle Principal #123, Ciudad
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    

</body>
</html>