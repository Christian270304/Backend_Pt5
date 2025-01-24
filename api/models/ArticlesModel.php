<?php
require_once 'conexion.php';

class ArticlesModel {

    
    public function getArticleById($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM articles WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getArticles() {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM articles ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>