<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre     = trim($_POST["nombre"]);
    $dni        = trim($_POST["dni"]);
    $edad       = trim($_POST["edad"]);
    $telefono   = trim($_POST["telefono"]);
    $contrasena = $_POST["contrasena"]; // usa sin ñ para evitar líos
    $correo     = trim($_POST["correo"]);

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

        // Insertar usuario con rol por defecto = cliente
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
        echo "Error en el registro: " . $e->getMessage();
    }
}
?>