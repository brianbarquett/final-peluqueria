<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['idusuario'])) {
    header("Location: /html/registro.html?mode=login");
    exit;
}

$user_id = $_SESSION['idusuario'];

try {
    // Validar datos recibidos
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['foto']['type'], $allowed_types)) {
            throw new Exception("Solo JPEG, PNG o GIF permitidos");
        }

        if ($_FILES['foto']['size'] > 2000000) {
            throw new Exception("Archivo demasiado grande (max 2MB)");
        }

        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $original_name = basename($_FILES['foto']['name']);
        $safe_name = preg_replace('/\s+/', '_', $original_name);
        $foto_filename = uniqid() . '_' . $safe_name;
        $foto_path = $target_dir . $foto_filename;
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path)) {
            throw new Exception("Error al subir la foto");
        }

        // Fetch la foto antigua
        $stmtOld = $pdo->prepare("SELECT foto FROM usuarios WHERE idusuario = :id");
        $stmtOld->execute([':id' => $user_id]);
        $old_foto = $stmtOld->fetchColumn();

        // Update BD
        $stmt = $pdo->prepare("UPDATE usuarios SET foto = :foto WHERE idusuario = :id");
        $stmt->execute([':foto' => $foto_filename, ':id' => $user_id]);

        // Update session
        $_SESSION['foto'] = $foto_filename;

        // Borrar antigua si existe
        if ($old_foto && file_exists($target_dir . $old_foto) && $old_foto !== $foto_filename) {
            unlink($target_dir . $old_foto);
        }
    } else {
        throw new Exception("No se subió foto");
    }

    header("Location: " . $_SERVER['HTTP_REFERER'] . "?t=" . time());
    exit;
} catch (Exception $e) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=" . urlencode($e->getMessage()));
    exit;
}