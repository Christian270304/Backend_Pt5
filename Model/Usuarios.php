<?php
// Model/Usuarios.php
require_once 'conexion.php'; // Asegúrate de incluir tu archivo de conexión

function obtenerUsuarios() {
    global $conn;
    $query = "SELECT id, username, email FROM users WHERE username != 'admin'"; // Asegúrate de que los nombres de las columnas sean correctos
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve todos los usuarios como un array asociativo
}

function eliminarUsuario($id) {
    global $conn;
    $query = "DELETE FROM users WHERE id = :id"; // Cambia "users" por el nombre de tu tabla
    $stmt = $conn->prepare($query);
    return $stmt->execute([':id' => $id]); // Devuelve true si se eliminó correctamente
}

function eliminarArticulosPorUsuario($userId) {
    global $conn;
    $query = "DELETE FROM articles WHERE user_id = :user_id";
    $stmt = $conn->prepare($query);
    return $stmt->execute([':user_id' => $userId]); // Ejecutar la consulta
}
?>