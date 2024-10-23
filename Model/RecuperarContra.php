<?php
    // Christian Torres Barrantes
    require_once 'conexion.php';

    // Obtener usuario por correo
    function obtenerUsuarioPorCorreo($correo) {
        global $conn;
        $query = "SELECT id FROM users WHERE email = :correo";
        $stmt = $conn->prepare($query);
        $stmt->execute([':correo' => $correo]);
        var_dump($stmt);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insertar token en la base de datos
    function insertarToken($usuario, $token, $expira) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO tokens (user_id, token, expira) VALUES (:id, :token, :expira)");
        return $stmt->execute([':id' => $usuario, ':token' => $token, ':expira' => $expira]);
    }
?>