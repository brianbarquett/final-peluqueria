<?php
require_once "conexion.php";

// Habilitar reporte de errores para desarrollo (quitar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar inputs
    $nombre     = trim($_POST["nombre"] ?? '');
    $dni        = trim($_POST["dni"] ?? '');
    $edad       = trim($_POST["edad"] ?? '');
    $telefono   = trim($_POST["telefono"] ?? '');
    $contrasena = $_POST["contrasena"] ?? ''; // No trim para contraseñas
    $correo     = trim($_POST["correo"] ?? '');

    // Validaciones del lado del servidor
    $errors = [];

    if (empty($nombre)) {
        $errors[] = "El nombre es obligatorio.";
    }

    if (!preg_match('/^\d{8}$/', $dni)) {
        $errors[] = "El DNI debe tener exactamente 8 dígitos.";
    }

    if (!filter_var($edad, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 120]])) {
        $errors[] = "La edad debe estar entre 1 y 120 años.";
    }

    if (!preg_match('/^\d{8,10}$/', $telefono)) {
        $errors[] = "El teléfono debe tener entre 8 y 10 dígitos.";
    }

    if (strlen($contrasena) < 6) {
        $errors[] = "La contraseña debe tener al menos 6 caracteres.";
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El correo electrónico no es válido.";
    }

    if (!empty($errors)) {
        // Redirigir con errores (puedes usar session o query params para mostrarlos)
        $_SESSION['errors'] = $errors; // Asumiendo que inicias session si es necesario
        header("Location: ../html/registro.html?mode=signup&error=validation");
        exit;
    }

    try {
        // Verificar si ya existe usuario con mismo correo o DNI
        $check = $pdo->prepare("SELECT idusuario FROM usuarios WHERE correo = :correo OR dni = :dni LIMIT 1");
        $check->execute([
            ":correo" => $correo,
            ":dni"    => $dni
        ]);

        if ($check->rowCount() > 0) {
            header("Location: ../html/registro.html?mode=signup&error=duplicate");
            exit;
        }

        // Encriptar contraseña
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Insertar usuario (rol se maneja por default en BD)
        $sql = "INSERT INTO usuarios (nombre, dni, edad, telefono, contrasena, correo)
                VALUES (:nombre, :dni, :edad, :telefono, :contrasena, :correo)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":nombre"     => $nombre,
            ":dni"        => $dni,
            ":edad"       => $edad,
            ":telefono"   => $telefono,
            ":contrasena" => $hash,
            ":correo"     => $correo
        ]);

        header("Location: ../html/registro.html?mode=login&success=1");
        exit;

    } catch (PDOException $e) {
        // Loggear el error en lugar de mostrarlo (para producción)
        error_log("Error en el registro: " . $e->getMessage());
        header("Location: ../html/registro.html?mode=signup&error=server");
        exit;
    }
} else {
    // Si no es POST, redirigir o mostrar error
    header("Location: ../html/registro.html");
    exit;
}
?>```