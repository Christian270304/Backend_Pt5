<?php
require_once 'conexion.php';

class UserModel {

    
    public function getUserById($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUsers() {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>