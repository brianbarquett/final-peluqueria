<?php
require_once 'conexion.php';

try {
    if (!isset($_POST['id'])) {
        throw new Exception("ID no proporcionado");
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($id === false) {
        throw new Exception("ID inválido");
    }

    // Fetch imagen para eliminar el archivo si existe
    $stmt = $pdo->prepare("SELECT imagen FROM barba WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $imagen = $stmt->fetchColumn();

    if ($imagen && file_exists($imagen)) {
        unlink($imagen);
    }

    // Eliminar el registro
    $stmt = $pdo->prepare("DELETE FROM barba WHERE id = :id");
    $stmt->execute([':id' => $id]);

    header("Location: admin/barba_admin.php");
    exit;
} catch (Exception $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>