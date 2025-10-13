<?php
require_once 'conexion.php';

try {
    // Validar datos recibidos
    if (!isset($_POST['titulo']) || !isset($_POST['descripcion'])) {
        throw new Exception("Título y descripción son obligatorios");
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);  // Será false si inválido, null si no set
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $imagen = null;

    // Validar que título y descripción no estén vacíos
    if (empty($titulo) || empty($descripcion)) {
        throw new Exception("Título y descripción no pueden estar vacíos");
    }

    // Manejo de la imagen
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['imagen']['type'], $allowed_types)) {
            throw new Exception("Solo se permiten imágenes JPEG, PNG o GIF");
        }

        $imagen_filename = uniqid() . '_' . basename($_FILES['imagen']['name']);
        $imagen_path = $target_dir . $imagen_filename;
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen_path)) {
            throw new Exception("Error al subir la imagen");
        }
        $imagen = $imagen_filename;  // Guardar solo filename en BD
    } elseif (isset($_POST['imagen_actual']) && !empty($_POST['imagen_actual'])) {
        $imagen = $_POST['imagen_actual'];  // Mantener filename actual
    }

    // Si no hay imagen (ni nueva ni actual), puedes dejar null o manejar error
    // if ($imagen === null) { throw new Exception("Debe proporcionar una imagen"); }  // Opcional: forzar imagen

    // Si no hay ID, tratar como null
    if ($id === null || $id === false) {
        $id = null;
    }

    // Verificar si existe
    $exists = false;
    if ($id !== null) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM portada WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $exists = $stmt->fetchColumn() > 0;
    }

    if ($exists) {
        // Actualizar
        $sql = "UPDATE portada SET titulo = :titulo, descripcion = :descripcion";
        $params = [':titulo' => $titulo, ':descripcion' => $descripcion];
        
        if ($imagen !== null) {
            $sql .= ", imagen = :imagen";
            $params[':imagen'] = $imagen;
        }
        
        $sql .= " WHERE id = :id";
        $params[':id'] = $id;
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    } else {
        // Insertar
        $sql = "INSERT INTO portada (titulo, descripcion, imagen) VALUES (:titulo, :descripcion, :imagen)";
        $params = [
            ':titulo' => $titulo,
            ':descripcion' => $descripcion,
            ':imagen' => $imagen
        ];
        
        if ($id !== null) {
            $sql = "INSERT INTO portada (id, titulo, descripcion, imagen) VALUES (:id, :titulo, :descripcion, :imagen)";
            $params[':id'] = $id;
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }

    header("Location: index_admin.php");  // Ajusta el nombre si es diferente
    exit;
} catch (Exception $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>