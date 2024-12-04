<?php
require_once __DIR__ . '\..\conexion.php';

function buscarUsuarioPorEmail($email) {
    global $conn;
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->execute([':email' => $email]);

    // Verificamos si se encontró un usuario
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        return true; // Usuario encontrado
    } else {
        return false; // Usuario no encontrado
    }
}

function crearUsuarioDesdeGoogle($email,$name) {
    global $conn;
    $query = "INSERT INTO users (username, email, OAuth, creado_el) VALUES (:username, :email, :OAuth, NOW())";
    $stmt = $conn->prepare($query);
    
        // Ejecutar la consulta
        $stmt->execute([
            ':username' => $name,
            ':email' => $email,
            ':OAuth' => 'Google'
        ]);
        return true; // Indica que la inserción fue exitosa
    // Verificar si se afectó una fila
    if ($stmt->rowCount() > 0) {
        return true; // Inserción exitosa
    } else {
        return false; // Error al insertar
    }
}


function crearUsuarioDesdeGitHub($email, $name) {
    global $conn;
    $query = "INSERT INTO users (username, email, OAuth, creado_el) VALUES (:username, :email, :OAuth, NOW())";
    $stmt = $conn->prepare($query);
    
    // Ejecutar la consulta
    $stmt->execute([
        ':username' => $name,
        ':email' => $email,
        ':OAuth' => 'GitHub'
    ]);
    
    // Verificar si se afectó una fila
    if ($stmt->rowCount() > 0) {
        return true; // Inserción exitosa
    } else {
        return false; // Error al insertar
    }
}
?>