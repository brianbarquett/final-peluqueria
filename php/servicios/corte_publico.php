<?php
require_once '../conexion.php';

$servicio = 'corte';  // Para este servicio

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
    <link rel="stylesheet" href="/css/servicio.css">
</head>
<body>
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
    </style>
    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/php/index_principal.php"><i class="bi bi-arrow-left-circle"></i>Gold Style</a>
            <div class="boton-nav">
                <a href="/html/registro.html?mode=login" class="btn btn-outline-light">Iniciar sesión</a>
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
    <!-- Nuevo Contenedor Intro (sin editar) -->
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