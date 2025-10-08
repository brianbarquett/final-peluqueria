<?php
// procesar_login.php
session_start();
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni        = trim($_POST["dni"]);
    $contrasena = $_POST["contrasena"];

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
            header("Location: ../html/registro.html?mode=login&error=1");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error en el login: " . $e->getMessage();
    }
}
?>