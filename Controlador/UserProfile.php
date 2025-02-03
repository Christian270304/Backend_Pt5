<?php
require_once 'model/Login.php';

$username = isset($_GET['username']) ? $_GET['username'] : "";
$resultado = buscarUsuario($username);
if ($resultado) {
    $articles = articulosUsuario($username);
} else {
    $error = "Usuario no encontrado";
    header('Location: index.php?pagina=UserProfile&username=' . $_SESSION['username']);
}


function formatoArticulos($articles){
    $article_data = "";
    for ($i = 0; $i < count($articles); $i++) {
        $article = $articles[$i];

        $article_data .= '<div class="card" id="' . $article['id'] . '">';
        $article_data .= '<img class="img-article" src="/Backend_Pt5/' . $article['ruta_imagen'] . '" alt="Imagen de ' . $article['titol'] . '">';
        $article_data .= '<div class="article-content">';
        $article_data .= '<h4 class="titulo">' . $article['titol'] . '</h4>';
        $article_data .= '<p class="texto">' . $article['cos'] . '</p>';
        $article_data .= '</div>';
        $article_data .= '</div>';
    } 
    return $article_data;
}
?>