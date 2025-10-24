<?php require 'conexion.php'; ?>

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
    <!-- Ruta corregida al CSS -->
    <link rel="stylesheet" href="/css/index.css">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">BarberShop Gold Style</a>
            <div class="boton-nav">
                <!-- Ruta corregida al login -->
                <a href="../html/registro.html?mode=login" class="btn btn-outline-light">Iniciar sesión</a>
            </div>
        </div>
    </nav>

    <!-- PORTADA -->
    <div class="portada" style="background-image: url('uploads/<?= htmlspecialchars($portada['imagen']) ?>');">
        <div class="portada-contenido">
            <h1><?= htmlspecialchars($portada['titulo']) ?></h1>
            <div class="linea"></div>
            <p><?= htmlspecialchars($portada['descripcion']) ?></p>
            <a href="sacar_turno.php" class="btn-transparente mt-3">Sacar turno</a><br>
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
                // Para no logueados, redirigir a servicios/{nombre}_publico.php
                $base_name = str_replace('.php', '', $servicio['link']);
                $link = 'servicios/' . $base_name . '_publico.php';
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
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>