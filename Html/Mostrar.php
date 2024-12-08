<!-- Christian Torres Barrantes -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
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
                    <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin'): ?>
                        <li><a href="index.php?pagina=Admin">Administrar Usuarios</a></li>
                    <?php endif; ?>
                    <li><a href="index.php?pagina=MostrarInici&logout=1">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
        <div class="menu-toggle" id="menu-toggle">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
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
            <form method="get" action="">
                <label for="articulosPorPagina">Artículos por página:</label>
                <?php $totalArticulos = totArticles(); ?>
                <input type="hidden" name="page" value="<?php echo isset($_GET['page']) ? (int)$_GET['page'] : 1; ?>">
                <input type="hidden" name="pagina" value="<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 'Mostrar'; ?>">
                <input type="number" name="articulosPorPagina" id="articulosPorPagina"
                    value="<?php echo isset($_GET['articulosPorPagina']) ? $_GET['articulosPorPagina'] : (isset($_COOKIE['articulosPorPagina_mostrar']) ? $_COOKIE['articulosPorPagina_mostrar'] : 5); ?>"
                    min="1" max="<?php echo $totalArticulos; ?>">
                <label for="order">Ordenar por:</label>
                <select name="order" id="order">
                    <option value="ASC" <?php echo (isset($_GET['order']) && $_GET['order'] == 'ASC') ? 'selected' : ''; ?>>Ascendente</option>
                    <option value="DESC" <?php echo (isset($_GET['order']) && $_GET['order'] == 'DESC') ? 'selected' : ''; ?>>Descendente</option>
                </select>
                <label for="search">Buscar Artículo:</label>
                <input type="text" name="search" id="search" placeholder="Buscar por título o contenido" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit">Actualizar</button>
            </form>

            <?php
            // Obtener la página actual de la URL, por defecto es 1
            $paginaActual = validarEntero('page', 1, 1, ceil($totalArticulos / 1));
            $articulosPorPagina = validarEntero('articulosPorPagina', 5, 1, $totalArticulos); // Número de artículos por página
            $searchQuery = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; // Obtener la consulta de búsqueda

            echo mostrarArticulos('Mostrar', $paginaActual, (isset($_COOKIE['articulosPorPagina_mostrar']) ? $_COOKIE['articulosPorPagina_mostrar'] : $articulosPorPagina), $searchQuery);  // Usar el valor de artículos por página
            ?>
        </div>
    </div>
    <script>
    // Obtener el ícono del menú, la barra de navegación y el contenedor del menú
    const menuToggle = document.getElementById('menu-toggle');
    const navBar = document.querySelector('.nav-bar');
    const body = document.querySelector('body');

    // Agregar un evento al ícono de menú
    menuToggle.addEventListener('click', () => {
        navBar.classList.toggle('active'); // Alternar la clase 'active' para mostrar/ocultar el menú

        // Alternar la clase 'hide' para mostrar/ocultar el ícono de hamburguesa
        menuToggle.classList.toggle('hide');
    });

    // Función para cerrar el menú si el clic fue fuera de la barra de navegación
    body.addEventListener('click', (event) => {
        // Verificar si el clic fue fuera del menú y del ícono de hamburguesa
        if (!navBar.contains(event.target) && !menuToggle.contains(event.target)) {
            navBar.classList.remove('active'); // Cerrar el menú
            menuToggle.classList.remove('hide'); // Mostrar el ícono de hamburguesa nuevamente
        }
    });
</script>
</body>

</html>