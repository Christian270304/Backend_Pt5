<?php 
    // Christian Torres Barrantes
    require_once 'Model/Mostrar.php';

    /** 
     *Funcion para crear la paginacion en las paginas.
     *$page El numero de pagina en la que esta el usuario.
     *$articlesPerPage El numero de articulos por pagina
    */
    function mostrarArticulos( $cat, $page=1, $articlesPerPage, $searchQuery = '') {
        $article_data = ""; // Contenedor para los artículos.
        $user_id = idUsuario($_SESSION['username']);
        $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
        $articles = selectUsuario($user_id, $order,$searchQuery); // Obtener los artículos de la base de datos
        
        if (isset($_GET['articulosPorPagina'])) {
            $articlesPerPage = intval($_GET['articulosPorPagina']);
            setcookie('articulosPorPagina_' . $cat, $articlesPerPage, time() + (86400 * 7), "/");  // Guardar cookie por 7 días
        } 

        // Verificar si hay una cookie con la última página visitada
        if (isset($_COOKIE['ultima_pagina_mostrar'])) {
            $page = intval($_COOKIE['ultima_pagina_mostrar']);
        }
        

        // Verificar si hay artículos
        if (empty($articles)) {
            return '<h1>Aun no has creado ningun articulo 😔</h1>';
        }

        // Calcular el número total de artículos
        $totalArticles = count($articles);
        $startIndex = ($page - 1) * $articlesPerPage;
        $endIndex = min($startIndex + $articlesPerPage, $totalArticles);

        // Mostrar artículos según la página
        for ($i = $startIndex; $i < $endIndex; $i++) {
            $article = $articles[$i];
            $article_data .= '<div class="user-article" id="' . $article['id'] . '">';
            $article_data .= '<img src="' . $article['ruta_imagen'] . '" alt="Imagen de ' . $article['titol'] . '">';
            $article_data .= '<div class="article-content">';
            $article_data .= '<h4 class="titulo">' . $article['titol'] . '</h4>';
            $article_data .= '<p class="texto">' . $article['cos'] . '</p>';
            $article_data .= '</div>';
            $article_data .= '<div class="card-actions">';
            $article_data .= '<button onclick="readArticle(' . $article['id'] . ')">Leer</button>';
            $article_data .= '<button onclick="editArticle(' . $article['id'] . ')">Editar</button>';
            $article_data .= '<button onclick="deleteArticle(' . $article['id'] . ')">Eliminar</button>';
            $article_data .= '</div>';
            $article_data .= '</div>'; 
        }

        
        $article_data .= generarPaginacion($page,$articlesPerPage,$cat,$articles);
        return $article_data;
    }


    /*
        Funcion para crear la paginacion en las paginas.
        $page El numero de pagina en la que esta el usuario.
        $articlesPerPage El numero de articulos por pagina
    */
    function generarPaginacion($pagina, $articlesPerPage,$cat,$articles) {
        $user_id = idUsuario($_SESSION['username']);
        $articles = selecArticleUsuario($user_id); // Obtener todos los artículos
        $totalArticles = count($articles); // Calcular el número total de artículos
        $totalPagines = ceil($totalArticles / max($articlesPerPage, 1)); // Número total de páginas
        
        

        // Verificar si el usuario ha seleccionado manualmente una página (desde la URL)
        if (isset($_GET['page'])) {
            $pagina = intval($_GET['page']);  // Si está en la URL, usamos el valor de la página
            // Actualizar la cookie solo si se seleccionó una nueva página
            setcookie("ultima_pagina_mostrar", $pagina, time() + (86400 * 7), "/");
        } elseif (isset($_COOKIE['ultima_pagina_mostrar'])) {
            // Si no hay valor en la URL, usamos la página almacenada en la cookie
            $pagina = intval($_COOKIE['ultima_pagina_mostrar']);
        } else {
            // Si no hay cookie ni valor en la URL, usamos la página 1 por defecto
            $pagina = 1; 
        }

        // Generar la barra de paginación
        $pagination = '<div class="pagination">';
    
        // Flechas a las paginas anteriores
        if ($pagina > 1) {
            $pagination .= '<a href="?pagina=' . $cat . '&page=1&articulosPorPagina=' . $articlesPerPage . '" class="arrow first">« Primera</a>';
            $pagination .= '<a href="?pagina=' . $cat . '&page=' . ($pagina - 1) . '&articulosPorPagina=' . $articlesPerPage . '" class="arrow next">« Anterior</a>';

        }
    
        // Calcular el rango de páginas a mostrar
        $maxVisiblePages = 4;
        $startPage = max(1, $pagina - floor($maxVisiblePages / 2));
        $endPage = min($totalPagines, $startPage + $maxVisiblePages - 1);
    
        // Ajustar el rango si hay menos de 4 páginas
        if ($endPage - $startPage + 1 < $maxVisiblePages) {
            $startPage = max(1, $endPage - $maxVisiblePages + 1);
        }
    
        // Mostrar enlaces de paginación
        for ($i = $startPage; $i <= $endPage; $i++) {
            if ($i == $pagina) {
                $pagination .= '<span class="current-page">' . $i . '</span>'; // Página actual
            } else {
                // Incluir artículos por página en el enlace de paginación
                $pagination .= '<a href="?pagina=' . $cat . '&page=' . $i . '&articulosPorPagina=' . $articlesPerPage . '">' . $i . '</a>'; // Enlace a la página
            }
        }
    
        // Flechas a la siguiente página
        if ($pagina < $totalPagines) {
            $pagination .= '<a href="?pagina=' . $cat . '&page=' . ($pagina + 1) . '&articulosPorPagina=' . $articlesPerPage . '" class="arrow next">Siguiente »</a>';
            $pagination .= '<a href="?pagina=' . $cat . '&page='. $totalPagines . '&articulosPorPagina=' . $articlesPerPage . '" class="arrow first">Última »</a>';
        }

    
        $pagination .= '</div>'; 
        return $pagination;
    }


    /*
        Funcion para validar los numeros de pagina y articulos por pagina de la url.
    */
    function validarEntero($parametro, $valorPorDefecto, $min = 1, $max = PHP_INT_MAX) {
        if (isset($_GET[$parametro]) && filter_var($_GET[$parametro], FILTER_VALIDATE_INT)) {
            $valor = (int)$_GET[$parametro];
            if ($valor >= $min && $valor <= $max) {
                return $valor;
            }
        }
        return $valorPorDefecto;
    }

    /*
        Funcion que retorna el total de articulos que hay en la base de datos.
    */
    function totArticles(){
        $user_id = idUsuario($_SESSION['username']);
        return countArticles($user_id);
    }
?>