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

// Fetch configs solo de lunes a sabado (sin domingo)
$stmt = $pdo->query("SELECT * FROM config_atencion WHERE dia_semana != 'domingo' ORDER BY FIELD(dia_semana, 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado')");
$configs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch foto del admin
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
    <title>Configuracion de Horarios - BarberShop Gold Style</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root {
            --gold-primary: #D4AF37;
            --gold-light: #F4E5B1;
            --gold-dark: #B8941E;
            --black-primary: #1a1a1a;
            --black-secondary: #2d2d2d;
            --black-light: #3d3d3d;
            --white: #ffffff;
        }

        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%);
            min-height: 100vh;
            padding-top: 80px;
            padding-bottom: 50px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--white);
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .page-title {
            color: var(--gold-primary);
            font-weight: 700;
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 40px;
            text-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
            letter-spacing: 2px;
        }

        .config-card {
            background: linear-gradient(145deg, #2d2d2d 0%, #1a1a1a 100%);
            border: 2px solid var(--gold-dark);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5), 0 0 20px rgba(212, 175, 55, 0.1);
            padding: 30px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .config-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.6), 0 0 30px rgba(212, 175, 55, 0.3);
            border-color: var(--gold-primary);
        }

        .day-header {
            background: linear-gradient(135deg, var(--gold-primary) 0%, var(--gold-dark) 100%);
            color: var(--black-primary);
            padding: 15px 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
        }

        .form-label {
            font-weight: 600;
            color: var(--gold-light);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid var(--black-light);
            background: var(--black-secondary);
            color: var(--white);
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--gold-primary);
            background: var(--black-light);
            color: var(--white);
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }

        .time-inputs-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .btn-save {
            background: linear-gradient(135deg, var(--gold-primary) 0%, var(--gold-dark) 100%);
            color: var(--black-primary);
            border: none;
            border-radius: 25px;
            padding: 12px 40px;
            font-size: 1rem;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.5);
            color: var(--black-primary);
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold-primary) 100%);
        }

        .btn-generate {
            background: linear-gradient(135deg, var(--gold-primary) 0%, var(--gold-dark) 100%);
            color: var(--black-primary);
            border: none;
            border-radius: 30px;
            padding: 15px 50px;
            font-size: 1.1rem;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(212, 175, 55, 0.4);
            display: block;
            margin: 40px auto;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .btn-generate:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.6);
            color: var(--black-primary);
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold-primary) 100%);
        }

        .alert-info {
            background: linear-gradient(145deg, #2d2d2d 0%, #1a1a1a 100%);
            border: 2px solid var(--gold-dark);
            border-radius: 15px;
            color: var(--gold-light);
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .alert-info i {
            font-size: 1.5rem;
            margin-right: 10px;
            color: var(--gold-primary);
        }

        .alert-info strong {
            color: var(--gold-primary);
        }

        .modal-content {
            border-radius: 20px;
            overflow: hidden;
            background: var(--black-secondary);
            border: 2px solid var(--gold-dark);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--gold-primary) 0%, var(--gold-dark) 100%);
            color: var(--black-primary);
            border: none;
        }

        .modal-body {
            background: var(--black-secondary);
            color: var(--white);
        }

        .modal-footer {
            border: none;
            background: var(--black-secondary);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: 2px;
            color: var(--gold-primary) !important;
            text-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
        }

        .navbar {
            background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%) !important;
            border-bottom: 2px solid var(--gold-dark);
            box-shadow: 0 2px 10px rgba(212, 175, 55, 0.2);
        }

        .back-btn {
            color: var(--gold-light);
            text-decoration: none;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-btn:hover {
            color: var(--gold-primary);
            transform: translateX(-5px);
            text-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
        }

        .btn-close-white {
            filter: brightness(0) invert(1);
        }

        .btn-secondary {
            background: var(--black-light);
            border-color: var(--gold-dark);
            color: var(--gold-light);
        }

        .btn-secondary:hover {
            background: var(--black-secondary);
            border-color: var(--gold-primary);
            color: var(--gold-primary);
        }

        .spinner-border {
            color: var(--gold-primary);
        }

        .text-success {
            color: var(--gold-primary) !important;
        }

        .text-danger {
            color: #ff6b6b !important;
        }

        .text-warning {
            color: #ffa500 !important;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .config-card {
                padding: 20px;
            }

            .time-inputs-row {
                grid-template-columns: 1fr;
            }
        }

        /* Scrollbar personalizado */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--black-primary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gold-dark);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gold-primary);
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-dark fixed-top">
        <div class="container-fluid">
            <a href="index_admin.php" class="back-btn">
                <i class="bi bi-arrow-left fs-4"></i>
                <span>Volver</span>
            </a>
            <a class="navbar-brand" href="index_admin.php">
                <i class="bi bi-scissors me-2"></i>
                GOLD STYLE
            </a>
            <div class="boton-nav d-flex align-items-center">
                <span class="text-white me-2" style="color: var(--gold-light) !important;"><?php echo htmlspecialchars($_SESSION["nombre"] ?? 'Admin'); ?></span>
                <img src="uploads/<?php echo htmlspecialchars($user_foto); ?>?t=<?php echo time(); ?>" alt="Foto de Perfil" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid var(--gold-primary);">
                <a href="config_admin.php" class="text-white me-2" style="color: var(--gold-light) !important;"><i class="bi bi-gear fs-4"></i></a>
                <a href="?logout=1" class="text-white" style="color: var(--gold-light) !important;"><i class="bi bi-box-arrow-right fs-4"></i></a>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <h1 class="page-title">
            <i class="bi bi-calendar-week me-2"></i>
            CONFIGURACION DE HORARIOS
        </h1>

        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            <strong>Importante:</strong> Configure los horarios de atencion para cada dia de la semana (Lunes a Sabado). Los domingos estan deshabilitados.
        </div>

        <?php foreach ($configs as $config): ?>
            <div class="config-card">
                <form method="POST">
                    <div class="day-header">
                        <i class="bi bi-calendar-day me-2"></i>
                        <?php echo strtoupper($config['dia_semana']); ?>
                    </div>
                    
                    <input type="hidden" name="dia_semana" value="<?php echo $config['dia_semana']; ?>">
                    
                    <div class="time-inputs-row">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-sunrise me-2"></i>Manana Inicio
                            </label>
                            <input type="time" class="form-control" name="manana_inicio" value="<?php echo $config['manana_inicio']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-sunrise-fill me-2"></i>Manana Fin
                            </label>
                            <input type="time" class="form-control" name="manana_fin" value="<?php echo $config['manana_fin']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-sunset me-2"></i>Tarde Inicio
                            </label>
                            <input type="time" class="form-control" name="tarde_inicio" value="<?php echo $config['tarde_inicio']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-sunset-fill me-2"></i>Tarde Fin
                            </label>
                            <input type="time" class="form-control" name="tarde_fin" value="<?php echo $config['tarde_fin']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-clock me-2"></i>Intervalo (minutos)
                            </label>
                            <input type="number" class="form-control" name="intervalo" value="<?php echo $config['intervalo']; ?>" min="15" max="60" step="15" required>
                        </div>
                    </div>
                    
                    <button type="submit" name="save_config" class="btn btn-save">
                        <i class="bi bi-save me-2"></i>Guardar <?php echo strtoupper($config['dia_semana']); ?>
                    </button>
                </form>
            </div>
        <?php endforeach; ?>

        <button id="generateBtn" class="btn btn-generate">
            <i class="bi bi-lightning-charge-fill me-2"></i>
            GENERAR HORARIOS
        </button>
    </div>

    <!-- Modal Exito para Guardar -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-check-circle-fill me-2"></i>EXITO
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Configuracion guardada correctamente para el dia seleccionado.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Generar -->
    <div class="modal fade" id="generateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-gear-fill me-2"></i>GENERACION DE HORARIOS
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="generateMessage">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Procesando...</span>
                        </div>
                        <p class="mt-3">Procesando...</p>
                    </div>
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
            const modal = new bootstrap.Modal(document.getElementById('generateModal'));
            modal.show();
            
            fetch('/php/generate_horarios.php')
                .then(response => response.json())
                .then(data => {
                    const icon = data.success ? '<i class="bi bi-check-circle-fill text-success fs-1"></i>' : '<i class="bi bi-x-circle-fill text-danger fs-1"></i>';
                    const message = data.success ? data.message : 'Error: ' + data.error;
                    document.getElementById('generateMessage').innerHTML = `
                        <div class="text-center">
                            ${icon}
                            <p class="mt-3 mb-0">${message}</p>
                        </div>
                    `;
                }).catch(error => {
                    document.getElementById('generateMessage').innerHTML = `
                        <div class="text-center">
                            <i class="bi bi-exclamation-triangle-fill text-warning fs-1"></i>
                            <p class="mt-3 mb-0">Error al generar: ${error}</p>
                        </div>
                    `;
                });
        });
    </script>
</body>
</html>