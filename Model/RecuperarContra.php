<?php
    // Christian Torres Barrantes
    require_once 'conexion.php';

    // Obtener usuario por correo
    function obtenerUsuarioPorCorreo($correo) {
        global $conn;
        $query = "SELECT id FROM users WHERE email = :correo";
        $stmt = $conn->prepare($query);
        $stmt->execute([':correo' => $correo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener usuario por username
    function obtenerUsuarioPorUsername($username) {
        global $conn;
        $query = "SELECT id FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener Token refresh
    function obtenerTokenRefresh($username) {
        global $conn;
        $query = "SELECT t.token
                FROM users u
                JOIN tokens t ON u.id = t.user_id
                WHERE u.username = :username AND t.type = 'refreshtoken'";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['token'];
    }

    // Insertar token en la base de datos
    function insertarToken($usuario, $token, $expira, $type) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO tokens (user_id, token, expira, type) VALUES (:id, :token, :expira, :type)");
        return $stmt->execute([':id' => $usuario, ':token' => $token, ':expira' => $expira, ':type' => $type]);
    }

    // Funcion para verificar si el usuario tiene una cuenta de Google
    function verificarCuentaSocial($user_id) {
        global $conn;
        $query = "SELECT OAuth FROM users WHERE id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>