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
        return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve un array o false
    }

    function buscarEmail($email){
        global $conn;
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->execute([':email' => $email]);
        if ($stmt->rowCount() > 0){
            return false;
        } else {
            return true;
        }

    }

    function  cambiarEmail($email,$user_id){
        global $conn;
        $query = "UPDATE users SET email = :email WHERE id = :id";
        $stmt = $conn->prepare($query);
        $resultado = $stmt->execute([':email' => $email ,':id' => $user_id]);
        if ($resultado && $stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function cambiarBio($bio,$user_id){
        global $conn;
        $query = "UPDATE users SET bio = :bio WHERE id = :id";
        $stmt = $conn->prepare($query);
        $resultado = $stmt->execute([':bio' => $bio ,':id' => $user_id]);
        if ($resultado && $stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function  cambiarUsername($username,$user_id){
        global $conn;
        $query = "UPDATE users SET username = :username WHERE id = :id";
        $stmt = $conn->prepare($query);
        $resultado = $stmt->execute([':username' => $username ,':id' => $user_id]);
        if ($resultado && $stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function email($user_id) {
        global $conn;
        $query = "SELECT email FROM users WHERE id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':user_id' => $user_id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado['email'] : null;
    }

    function bio($user_id) {
        global $conn;
        $query = "SELECT bio FROM users WHERE id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':user_id' => $user_id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado['bio'] : null;
    }

    function username($user_id) {
        global $conn;
        $query = "SELECT username FROM users WHERE id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':user_id' => $user_id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado['username'] : null;
    }

    function password($user_id) {
        global $conn;
        $query = "SELECT password FROM users WHERE id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':user_id' => $user_id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado['password'] : null;
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