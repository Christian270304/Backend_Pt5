<?php
    // Christian Torres Barrantes
    require_once 'conexion.php';

    /**
     * Funcion para verificar si el usuario existe dentro de la base de datos.
     */
    function usrExist($username, $correo){
        global $conn;
        $query = "SELECT * FROM users WHERE username = :username OR email = :correo";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username, ':correo' => $correo]);
        $stmt->fetchAll();
        return $stmt;
    }

    /**
     * Funcion para insertat el usuario dentro de la base de datos.
     */
    function insertarUsuario($username, $corre, $contra){
        global $conn;
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :correo , :contra)";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username, ':correo' => $corre, ':contra' => $contra]);
        return $stmt;
    }
?>