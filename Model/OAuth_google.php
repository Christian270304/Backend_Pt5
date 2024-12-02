<?php
require_once 'conexion.php';

function buscarUsuarioPorEmail($email) {
    global $conn;
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->execute([':email' => $email]);
    return $stmt->fetch (PDO::FETCH_ASSOC);
}

function crearUsuarioDesdeGoogle($email,$name) {
    global $conn;
    $query = "INSERT INTO users (username, email, OAuth, creado_el) VALUES (:username, :email, :OAuth, NOW())";
    $stmt = $conn->prepare($query);
    try {
        // Ejecutar la consulta
        $stmt->execute([
            ':username' => $name,
            ':email' => $email,
            ':OAuth' => 'Google'
        ]);
        return true; // Indica que la inserción fue exitosa
    } catch (PDOException $e) {
        // Manejo de errores, puedes registrar el error o mostrar un mensaje
        error_log("Error al crear usuario: " . $e->getMessage());
        return false; // Indica que hubo un error
    }
}
?>