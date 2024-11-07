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

    // Buscar un usuario por nombre de usuario
    function buscarUsuario($username) {
        global $conn;
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function email($user_id) {
        global $conn;
        $query = "SELECT email FROM users WHERE id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':user_id' => $user_id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado['email'] : null;
    }

    function cambiarPassword($user_id,$password) {
        global $conn;
        $query = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $conn->prepare($query);
        $resultado = $stmt->execute([':password' => $password ,':id' => $user_id]);
        if ($resultado && $stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
?>