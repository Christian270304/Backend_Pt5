<?php
    // Christian Torres Barrantes
    require_once 'conexion.php';
    // Buscar un usuario por nombre de usuario
    function buscarUsuario($username) {
        global $conn;
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function guardarToken($userId, $token) {
        global $conn;
        $expira = date("Y-m-d H:i:s", strtotime('+30 days')); // Expira en 30 días
        $stmt = $conn->prepare("INSERT INTO tokens (user_id, token, expira) VALUES (:user_id, :token, :expira)");
        $stmt->execute([':user_id' => $userId, ':token' => $token, ':expira' => $expira]);
    }

    
?>