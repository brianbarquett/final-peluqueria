<?php
// procesar_login.php
session_start();
require_once "conexion.php";

// Habilitar reporte de errores para desarrollo (quitar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar inputs
    $dni        = trim($_POST["dni"] ?? '');
    $contrasena = $_POST["contrasena"] ?? ''; // No trim para contraseñas

    // Validaciones del lado del servidor
    $errors = [];

    if (empty($dni)) {
        $errors[] = "El DNI es obligatorio.";
    } elseif (!preg_match('/^\d{8}$/', $dni)) {
        $errors[] = "El DNI debe tener exactamente 8 dígitos.";
    }

    if (empty($contrasena)) {
        $errors[] = "La contraseña es obligatoria.";
    } elseif (strlen($contrasena) < 6) {
        $errors[] = "La contraseña debe tener al menos 6 caracteres.";
    }

    if (!empty($errors)) {
        // Redirigir con errores (puedes usar session o query params para mostrarlos)
        $_SESSION['errors'] = $errors; // Guardar errores en sesión
        header("Location: ../html/registro.html?mode=login&error=validation");
        exit;
    }

    try {
        // Buscar usuario por DNI
        $sql = "SELECT idusuario, nombre, dni, contrasena, rol 
                FROM usuarios 
                WHERE dni = :dni
                LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":dni" => $dni]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($contrasena, $usuario["contrasena"])) {
            // Guardar datos en sesión
            $_SESSION["idusuario"] = $usuario["idusuario"];
            $_SESSION["nombre"]    = $usuario["nombre"];
            $_SESSION["dni"]       = $usuario["dni"];
            $_SESSION["rol"]       = $usuario["rol"];

            // Redirigir según el rol
            if ($usuario["rol"] === "admin") {
                header("Location: ../php/index_admin.php");
            } else {
                header("Location: ../php/index_cliente.php");
            }
            exit;
        } else {
            // Redirigir con error para mostrar el modal
            $_SESSION['errors'] = ["DNI o contraseña incorrectos."];
            header("Location: ../html/registro.html?mode=login&error=1");
            exit;
        }
    } catch (PDOException $e) {
        // Loggear el error en lugar de mostrarlo (para producción)
        error_log("Error en el login: " . $e->getMessage());
        header("Location: ../html/registro.html?mode=login&error=server");
        exit;
    }
} else {
    // Si no es POST, redirigir o mostrar error
    header("Location: ../html/registro.html?mode=login");
    exit;
}
?>