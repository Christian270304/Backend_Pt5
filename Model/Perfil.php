<?php
    // Christian Torres Barrantes

    require_once 'conexion.php';

    function idUsuario($username) {
        global $conn;
        $query = "SELECT id FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username]);
        return $stmt->fetchColumn(); 
    }

    function email($user_id) {
        global $conn;
        $query = "SELECT email FROM users WHERE id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':user_id' => $user_id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado['email'] : null;
    }
?>