<!-- Christian Torres Barrantes -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar</title>
    <link href="Estilos/estilos.css" rel="stylesheet">
</head>

<body>
    <?php
    // PHP: Comprobar si el usuario ya tiene una imagen guardada
    $defaultImage = "https://storage.googleapis.com/a1aa/image/JLwi3piUzQY3G92u0CH63SjxE3kuf8lWqsoTZH7fYWfAkqWnA.jpg"; // URL predeterminada
    $profileImage = (!empty(isset($_SESSION['profile_image']))) ? $_SESSION['profile_image'] : $defaultImage;
    ?>
    <div class="container">
        <div class="account">
            <div class="account-icon">
                <img src="<?php echo $profileImage; ?>" alt="Foto de perfil">
                <ul class="dropdown">
                    <li><a href="index.php?pagina=Perfil">Perfil</a></li>
                    <li><a href="index.php?pagina=MostrarInici">Cerrrar Sesion</a></li>
                </ul>
            </div>
        </div>
        <div class="nav-grid">
            <nav class="nav-bar">
                <ul>
                    <li><a href="index.php?pagina=Inicio"><img class="icon" src="Imagenes/house.svg"><span>Inici</span></a></li>
                    <li><a href="index.php?pagina=Mostrar"><img class="icon" src="Imagenes/newspaper.svg"><span>Articles</span></a></li>
                    <li><a href="index.php?pagina=Insertar"><img class="icon" src="Imagenes/add-square.svg"><span>Insertar Article</span></a></li>
                    <li><a href="index.php?pagina=Borrar"><img class="icon" src="Imagenes/delete-button.svg"><span>Borrar Article</span></a></li>
                    <li><a href="index.php?pagina=Modificar"><img class="icon" src="Imagenes/edit.svg"><span>Modificar Article</span></a></li>
                </ul>
            </nav>
        </div>
       
        <div class="content"> 
            <h1>Que Articulo quieres Modificar?</h1>         
            <form method="get" action="">
                <label for="articulosPorPagina">Artículos por página:</label>
                <?php
                $totalArticulos = totArticles(); // Obtener el total de artículos
                ?>
                <input type="hidden" name="page" value="<?php echo isset($_GET['page']) ? (int)$_GET['page'] : 1; ?>">
                <input type="hidden" name="pagina" value="<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 'Mostrar'; ?>">
                <input type="number" name="articulosPorPagina" id="articulosPorPagina" 
                    value="<?php echo isset($_GET['articulosPorPagina']) ? $_GET['articulosPorPagina'] : (isset($_COOKIE['articulosPorPagina_modificar']) ? $_COOKIE['articulosPorPagina_modificar'] : 5 ); ?>" 
                    min="1" max="<?php echo $totalArticulos; ?>">
                <button type="submit">Actualizar</button>
            </form>

            <?php
            // Obtener la página actual de la URL, por defecto es 1
            $paginaActual = validarEntero('page', 1, 1, ceil($totalArticulos / 1));
            $articulosPorPagina = validarEntero('articulosPorPagina', 5, 1, $totalArticulos);

            echo mostrarArticulos(true, 'Modificar' , $paginaActual, (isset($_COOKIE['articulosPorPagina_modificar']) ? $_COOKIE['articulosPorPagina_modificar'] : $articulosPorPagina ));  // Usar el valor de artículos por página
            ?>
        </div>
    </div>
    <script>
        function redireccion(id){
            window.location.href = "index.php?pagina=ModificarArticulo&id=" + id;
        }
    </script>
</body>

</html>