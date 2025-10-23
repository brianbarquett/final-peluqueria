<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST["correo"] ?? '');

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../html/registro.html?mode=login&error=validation");
        exit;
    }

    try {
        // Verificar si el correo existe en usuarios
        $check = $pdo->prepare("SELECT idusuario FROM usuarios WHERE correo = :correo LIMIT 1");
        $check->execute([":correo" => $correo]);
        if ($check->rowCount() === 0) {
            header("Location: ../html/registro.html?mode=login&error=1"); // Error genérico para no revelar existencia
            exit;
        }

        // Generar token único y expiry (1 hora)
        $token = bin2hex(random_bytes(32));
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Guardar en password_resets (elimina previos para el mismo correo)
        $deleteOld = $pdo->prepare("DELETE FROM password_resets WHERE correo = :correo");
        $deleteOld->execute([":correo" => $correo]);

        $insert = $pdo->prepare("INSERT INTO password_resets (correo, token, expiry) VALUES (:correo, :token, :expiry)");
        $insert->execute([":correo" => $correo, ":token" => $token, ":expiry" => $expiry]);

        // Enviar email (ajusta el from y el dominio)
        $resetLink = "http://tu-dominio.com/php/reset_password.php?token=" . $token;
        $subject = "Recuperación de Contraseña - Gold Style";
        $message = "Haz clic en este link para resetear tu contraseña: " . $resetLink . "\nEl link expira en 1 hora.";
        $headers = "From: no-reply@tu-dominio.com";

        if (mail($correo, $subject, $message, $headers)) {
            header("Location: ../html/registro.html?mode=login&success=reset_sent"); // Agrega un success para mostrar modal
        } else {
            header("Location: ../html/registro.html?mode=login&error=server");
        }
        exit;

    } catch (PDOException $e) {
        error_log("Error en recuperación: " . $e->getMessage());
        header("Location: ../html/registro.html?mode=login&error=server");
        exit;
    }
} else {
    header("Location: ../html/registro.html?mode=login");
    exit;
}
?>