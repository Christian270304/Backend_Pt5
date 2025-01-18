<?php
require_once '../conexion.php';
function selectUsuario($article_id){
    global $conn;
    $query = "SELECT * FROM articles WHERE id = :id ";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id',$article_id , PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>