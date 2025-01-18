<?php
require_once '../Model/ajax.php';
$articleId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$article = selectUsuario($articleId);

if ($article) {
    echo json_encode([
        'image' => $article['ruta_imagen'],
        'title' => $article['titol'],
        'content' => $article['cos']
    ]);
} else {
    echo json_encode(['error' => 'Artículo no encontrado']);
}
?>