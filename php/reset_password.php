<?php
require_once "conexion.php";
session_start();

$token = $_GET['token'] ?? '';
$newPassword = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'] ?? '';
    $newPassword = $_POST['contrasena'] ?? '';
    $confirmPassword = $_POST['confirmar_contrasena'] ?? '';

    if (strlen($newPassword) < 6 || $newPassword !== $confirmPassword) {
        $error = "Las contraseñas no coinciden o son demasiado cortas.";
    } else {
        try {
            // Verificar token válido y no expirado
            $check = $pdo->prepare("SELECT correo FROM password_resets WHERE token = :token AND expiry > NOW() LIMIT 1");
            $check->execute([":token" => $token]);
            $row = $check->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $correo = $row['correo'];
                $hash = password_hash($newPassword, PASSWORD_DEFAULT);

                // Actualizar contraseña en usuarios
                $update = $pdo->prepare("UPDATE usuarios SET contrasena = :hash WHERE correo = :correo");
                $update->execute([":hash" => $hash, ":correo" => $correo]);

                // Eliminar token usado
                $delete = $pdo->prepare("DELETE FROM password_resets WHERE token = :token");
                $delete->execute([":token" => $token]);

                $_SESSION['success'] = "Contraseña actualizada con éxito.";
                header("Location: ../html/registro.html?mode=login&success=1");
                exit;
            } else {
                $error = "Token inválido o expirado.";
            }
        } catch (PDOException $e) {
            $error = "Error en el servidor.";
        }
    }
}

// Si no hay token válido, redirigir
if (empty($token)) {
    header("Location: ../html/registro.html?mode=login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resetear Contraseña</title>
    <link rel="stylesheet" href="/css/registro.css"> <!-- Reusa tu CSS -->
</head>
<body>
    <div class="container">
        <h2>Resetear Contraseña</h2>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="reset_password.php" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <input type="password" name="contrasena" placeholder="Nueva Contraseña" required minlength="6">
            <input type="password" name="confirmar_contrasena" placeholder="Confirmar Contraseña" required minlength="6">
            <button type="submit">Actualizar</button>
        </form>
    </div>
</body>
</html>