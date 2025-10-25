<?php
require_once 'conexion.php';

try {
    if (!isset($_POST['titulo']) || !isset($_POST['descripcion']) || !isset($_POST['servicio'])) {
        throw new Exception("Título, descripción y servicio son obligatorios");
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);  // Puede ser null
    $servicio = trim($_POST['servicio']);
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);

    if (empty($titulo) || empty($descripcion) || empty($servicio)) {
        throw new Exception("Campos no pueden estar vacíos");
    }

    // Verificar si existe
    $exists = false;
    if ($id !== null && $id !== false) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM intro_servicios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $exists = $stmt->fetchColumn() > 0;
    }

    if ($exists) {
        // Actualizar
        $sql = "UPDATE intro_servicios SET titulo = :titulo, descripcion = :descripcion WHERE id = :id";
        $params = [':titulo' => $titulo, ':descripcion' => $descripcion, ':id' => $id];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    } else {
        // Insertar nuevo (o upsert por servicio)
        $sql = "INSERT INTO intro_servicios (servicio, titulo, descripcion) VALUES (:servicio, :titulo, :descripcion)
                ON DUPLICATE KEY UPDATE titulo = :titulo, descripcion = :descripcion";
        $params = [':servicio' => $servicio, ':titulo' => $titulo, ':descripcion' => $descripcion];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }

    // Redirigir de vuelta a la página de admin del servicio
    header("Location: /php/admin/{$servicio}_admin.php");
    exit;
} catch (Exception $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}