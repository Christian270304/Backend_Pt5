<?php
    // Christian Torres Barrantes
    require_once 'conexion.php';

    // Obtener usuario por token
    function obtenerUsuarioPorToken($token) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM tokens WHERE token = :token AND expira > NOW()");
        $stmt->execute([':token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar la contraseña del usuario
    function actualizarContrasena($correo, $hashed_password) {
        global $conn;
        $stmt = $conn->prepare("UPDATE users SET password = :contra WHERE email = :correo");
        $stmt->execute([':contra' => $hashed_password, ':correo' => $correo]);
    }

    // Borrar el token después de usarlo
    function borrarToken($token) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM tokens WHERE token = :token");
        $stmt->execute([':token' => $token]);
    }
?>