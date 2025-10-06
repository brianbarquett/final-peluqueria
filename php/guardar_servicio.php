<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seccion = $_POST['seccion'] ?? '';
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';

    // Manejar subida de imagen
    $imagen = null; // Se obtendrá de BD inicialmente, pero como no se pasa, asumimos que se actualiza solo si se sube nueva
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nuevo_nombre = $seccion . '_' . time() . '.' . $file_extension;
        $ruta_destino = $upload_dir . $nuevo_nombre;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
            $imagen = $nuevo_nombre;
        } else {
            echo "Error al subir la imagen.";
            exit;
        }
    }

    // Si no se subió nueva imagen, mantener la actual (obtener de BD)
    if (!$imagen) {
        $stmt_actual = $pdo->prepare("SELECT imagen FROM servicios WHERE seccion = ?");
        $stmt_actual->execute([$seccion]);
        $actual = $stmt_actual->fetch();
        $imagen = $actual['imagen'] ?? null;
    } else {
        // Eliminar imagen anterior si existe
        $stmt_actual = $pdo->prepare("SELECT imagen FROM servicios WHERE seccion = ?");
        $stmt_actual->execute([$seccion]);
        $actual = $stmt_actual->fetch();
        if ($actual['imagen'] && file_exists($upload_dir . $actual['imagen']) && $actual['imagen'] !== 'default.jpg') {
            unlink($upload_dir . $actual['imagen']);
        }
    }

    // Actualizar en la base de datos
    $stmt = $pdo->prepare("UPDATE servicios SET titulo = ?, descripcion = ?, imagen = ? WHERE seccion = ?");
    $stmt->execute([$titulo, $descripcion, $imagen, $seccion]);

    // Redirigir de vuelta al index
    header('Location: index_admin.php?success=servicio');
    exit;
} else {
    header('Location: index_admin.php?error=method');
    exit;
}
?>