<?php
require_once 'conexion.php';

try {
    // Validar datos recibidos
    if (!isset($_POST['titulo']) || !isset($_POST['descripcion']) || !isset($_POST['precio'])) {
        throw new Exception("Título, descripción y precio son obligatorios");
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $imagen = null;

    // Validar que título y descripción no estén vacíos, y precio sea válido
    if (empty($titulo) || empty($descripcion) || $precio === false || $precio < 0) {
        throw new Exception("Los campos son inválidos o el precio no es válido");
    }

    // Manejo de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['imagen']['type'], $allowed_types)) {
            throw new Exception("Solo se permiten imágenes JPEG, PNG o GIF");
        }

        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $original_name = basename($_FILES['imagen']['name']);
        $safe_name = preg_replace('/\s+/', '_', $original_name);  // Reemplaza espacios con guiones bajos
        $imagen = $target_dir . uniqid() . '_' . $safe_name;
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen)) {
            throw new Exception("Error al subir la imagen");
        }
    }

    if ($id === 0) {
        // Insertar nuevo contenedor
        $stmt = $pdo->prepare("INSERT INTO peinado (titulo, descripcion, precio, imagen) VALUES (:titulo, :descripcion, :precio, :imagen)");
        $stmt->execute([
            ':titulo' => $titulo,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':imagen' => $imagen
        ]);
    } else {
        // Actualizar contenedor existente
        $sql = "UPDATE peinado SET titulo = :titulo, descripcion = :descripcion, precio = :precio";
        $params = [':titulo' => $titulo, ':descripcion' => $descripcion, ':precio' => $precio];
        
        if ($imagen) {
            $sql .= ", imagen = :imagen";
            $params[':imagen'] = $imagen;
        }
        
        $sql .= " WHERE id = :id";
        $params[':id'] = $id;
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }

    header("Location: admin/peinado_admin.php");  // Redirige a la versión admin después de guardar
    exit;
} catch (Exception $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>