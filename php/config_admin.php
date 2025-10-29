<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['idusuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index_principal.php");
    exit;
}

if (isset($_POST['save_config'])) {
    $dia = $_POST['dia_semana'];
    $manana_inicio = $_POST['manana_inicio'];
    $manana_fin = $_POST['manana_fin'];
    $tarde_inicio = $_POST['tarde_inicio'];
    $tarde_fin = $_POST['tarde_fin'];
    $intervalo = (int) $_POST['intervalo'];

    $stmt = $pdo->prepare("INSERT INTO config_atencion (dia_semana, manana_inicio, manana_fin, tarde_inicio, tarde_fin, intervalo) VALUES (:dia, :mi, :mf, :ti, :tf, :int) ON DUPLICATE KEY UPDATE manana_inicio = :mi, manana_fin = :mf, tarde_inicio = :ti, tarde_fin = :tf, intervalo = :int");
    $stmt->execute([
        ':dia' => $dia,
        ':mi' => $manana_inicio,
        ':mf' => $manana_fin,
        ':ti' => $tarde_inicio,
        ':tf' => $tarde_fin,
        ':int' => $intervalo
    ]);
    header("Location: config_admin.php?success=1&dia=$dia");
    exit;
}

// Fetch all configs por día
$stmt = $pdo->query("SELECT * FROM config_atencion ORDER BY FIELD(dia_semana, 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo')");
$configs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a href="index_admin.php" class="text-white me-3"><i class="bi bi-arrow-left fs-4"></i> Volver al Inicio</a>
            <a class="navbar-brand" href="#">BarberShop Gold Style</a>
            <div class="boton-nav d-flex align-items-center">
                <span class="text-white me-2"><?php echo htmlspecialchars($_SESSION["nombre"] ?? 'Admin'); ?></span>
                <img src="https://via.placeholder.com/40" alt="Foto de Perfil" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                <a href="config_admin.php" class="text-white me-2"><i class="bi bi-gear fs-4"></i></a>
                <a href="?logout=1" class="text-white"><i class="bi bi-box-arrow-right fs-4"></i></a>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <h2>Configuración de Horarios por Día</h2>
        <?php foreach ($configs as $config): ?>
            <form method="POST" class="mb-4">
                <h4><?php echo ucfirst($config['dia_semana']); ?></h4>
                <input type="hidden" name="dia_semana" value="<?php echo $config['dia_semana']; ?>">
                <div class="mb-3">
                    <label>Mañana Inicio</label>
                    <input type="time" class="form-control" name="manana_inicio" value="<?php echo $config['manana_inicio']; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Mañana Fin</label>
                    <input type="time" class="form-control" name="manana_fin" value="<?php echo $config['manana_fin']; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Tarde Inicio</label>
                    <input type="time" class="form-control" name="tarde_inicio" value="<?php echo $config['tarde_inicio']; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Tarde Fin</label>
                    <input type="time" class="form-control" name="tarde_fin" value="<?php echo $config['tarde_fin']; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Intervalo (minutos)</label>
                    <input type="number" class="form-control" name="intervalo" value="<?php echo $config['intervalo']; ?>" min="15" max="60" required>
                </div>
                <button type="submit" name="save_config" class="btn btn-primary">Guardar <?php echo ucfirst($config['dia_semana']); ?></button>
            </form>
        <?php endforeach; ?>
        <button id="generateBtn" class="btn btn-success">Generar Horarios Automáticamente</button>
    </div>

    <!-- Modal Éxito para Guardar -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Éxito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Configuración guardada para el día.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Generar (éxito/error) -->
    <div class="modal fade" id="generateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generación de Horarios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="generateMessage">
                    Procesando...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        <?php if (isset($_GET['success'])): ?>
            new bootstrap.Modal(document.getElementById('successModal')).show();
        <?php endif; ?>

        document.getElementById('generateBtn').addEventListener('click', () => {
            fetch('/php/generate_horarios.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('generateMessage').textContent = data.success ? data.message : 'Error: ' + data.error;
                    new bootstrap.Modal(document.getElementById('generateModal')).show();
                }).catch(error => {
                    document.getElementById('generateMessage').textContent = 'Error al generar: ' + error;
                    new bootstrap.Modal(document.getElementById('generateModal')).show();
                });
        });
    </script>
</body>
</html>