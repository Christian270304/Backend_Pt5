<?php
    // Christian Torres Barrantes
    require_once 'Model/Borrar.php';

    /* 
        Funcion para mostrar el titulo y el cuerpo dentro de la pagina BorrarVerificar.
    */
    
    function verificarDelet($id)  {
        $ids = isset($id) ? intval(trim(($id))) : 0;
        $user_id = idUsuario($_SESSION['username']);
        $article = selectOne($ids,$user_id);
        
        $titol = '';
        $cos = '';
        if ($article== null){
            include 'Html/403.php';
            return;
        } 
        $titol = $article['titol'];
        $cos = $article['cos'];
        include 'Html/BorrarVerificar.php';
    }

    /*
        Funcion para borrar el articulo que ha seleccionado el usuario.
    */
    function borrar($titulo,$cuerpo)  {
        $titol = isset($titulo) ? trim($titulo) : '';
        $cos = isset($cuerpo) ? trim($cuerpo) : '';
        $id = selectId($titol,$cos);
        if ($id != null){
        $mensaje = borrarArticle($id);
        header("Location: index.php?pagina=Borrar");
        } else{
            echo "Fallo";
        }
        
    }

    /**
     * Funcion para mostrar los articulos del usuario logueado.
     * @click parametro para que el articulo sea clickable o no dependiendo de la pagina en la que estemos (Borrar o Modificar)
     * @cat Parametro que nos indica en que pagina de la web nos encontramos.
     * @page Parametro que nos indica en que pagina de la paginacion nos encontramos.
     * @articlesPerPage Parametro que nos indica cuantos articulos por pagina desea el usuario.
     */
    function mostrarArticulos($click = false, $cat, $page = 1, $articlesPerPage = 5) {
        $article_data = '<div class="articulo-container">'; // Contenedor para los artículos.
        $user_id = idUsuario($_SESSION['username']);
        $articles = selectUsuario($user_id); // Obtener los artículos de la base de datos
        
        if (isset($_GET['articulosPorPagina'])) {
            $articlesPerPage = intval($_GET['articulosPorPagina']);
            setcookie('articulosPorPagina_borrar', $articlesPerPage, time() + (86400 * 7), "/");  // Guardar cookie por 7 días
        } 

        // Verificar si hay artículos
        if (empty($articles)) {
            return '<h2>No tienes articulos para borrar</h2>';
        }

        // Calcular el número total de artículos
        $totalArticles = count($articles);
        $startIndex = ($page - 1) * $articlesPerPage;
        $endIndex = min($startIndex + $articlesPerPage, $totalArticles);

        // Mostrar artículos según la página
        for ($i = $startIndex; $i < $endIndex; $i++) {
            $article = $articles[$i];
            if (!$click && $cat == 'Mostrar') {
                $article_data .= '<div class="articulo" id="' . $article['id'] . '">';
                $article_data .= '<h2 class="titulo">' . $article['titol'] . '</h2>';
                $article_data .= '<p class="texto">' . $article['cos'] . '</p>';
                $article_data .= '</div>';
            } elseif ($cat == 'Borrar') {
                $article_data .= '<button onclick="redireccion(' . $article['id'] . ')" class="selectB" id="' . $article['id'] . '">';
                $article_data .= '<h2 class="titulo">' . $article['titol'] . '</h2>';
                $article_data .= '<p class="texto">' . $article['cos'] . '</p>';
                $article_data .= '</button>';
            } else { // Para la opción de Modificar
                $article_data .= '<button onclick="redireccion(' . $article['id'] . ')" class="selectM" id="' . $article['id'] . '">';
                $article_data .= '<h2 class="titulo">' . $article['titol'] . '</h2>';
                $article_data .= '<p class="texto">' . $article['cos'] . '</p>';
                $article_data .= '</button>';
            }
        }

        $article_data .= '</div>'; // Cerrar el contenedor de artículos
        $article_data .= generarPaginacion($page,$articlesPerPage,$cat);
        return $article_data;
    }

    /** 
     *Funcion para crear la paginacion en las paginas.
     *$page El numero de pagina en la que esta el usuario.
     *$articlesPerPage El numero de articulos por pagina
    */
    function generarPaginacion($pagina, $articlesPerPage,$cat) {
        $user_id = idUsuario($_SESSION['username']);
        $articles = selectUsuario($user_id); // Obtener todos los artículos
        $totalArticles = count($articles); // Calcular el número total de artículos
        $totalPagines = ceil($totalArticles / $articlesPerPage); // Número total de páginas

        // Verificar si el usuario ha seleccionado manualmente una página (desde la URL)
        if (isset($_GET['page'])) {
            $pagina = intval($_GET['page']);  // Si está en la URL, usamos el valor de la página
            // Actualizar la cookie solo si se seleccionó una nueva página
            setcookie("ultima_pagina_borrar", $pagina, time() + (86400 * 7), "/");
        } elseif (isset($_COOKIE['ultima_pagina_borrar'])) {
            // Si no hay valor en la URL, usamos la página almacenada en la cookie
            $pagina = intval($_COOKIE['ultima_pagina_borrar']);
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

    /*
        Funcion para verificar si el id pasado por parametro exite dentro de la base de datos.
        Devuelve true si el artículo existe, false si no.
    */
    function verificarId($id,$user_id) {
        $verificar = selectOne($id,$user_id);
        return $verificar ? true : false;
    }
?>