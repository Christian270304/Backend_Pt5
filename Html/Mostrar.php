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
<div class="container">
<form method="get" action="">
    <div class="header">
        <div class="logo">
            <a href="">
                <img src="images/favicon.png" alt="Logotip de la pàgina">
            </a>
        </div>
        <?php if (isset($_SESSION['username'])): ?>
                <nav>
                    <ul>
                        <li><a href="index.php?pagina=Inicio" id="showAllArticles" >Inici</a></li>
                        <li><a href="index.php?pagina=Mostrar" id="showMyArticles" >Articles</a></li>
                        <li><a href="index.php?pagina=Insertar" id="newArticle" >Crear Article</a></li>
                        <li><a href="index.php?pagina=LeerQR">Leer QR</a></li>
                    </ul>
                </nav>
        <?php endif; ?>
        
            <div class="search-bar">
                <input type="text" name="search" id="search" placeholder="Buscar por título o contenido" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            </div>
            <div class="articles-per-page">
                <label for="articlesPerPage">Artículos por página:</label>
                <?php $totalArticulos = totArticles(); ?>
                <input type="hidden" name="page" value="<?php echo isset($_GET['page']) ? (int)$_GET['page'] : 1; ?>">
                <input type="hidden" name="pagina" value="<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 'Mostrar'; ?>">
                <input type="number" name="articulosPorPagina" id="articulosPorPagina"
                    value="<?php echo isset($_GET['articulosPorPagina']) ? $_GET['articulosPorPagina'] : (isset($_COOKIE['articulosPorPagina_mostrar']) ? $_COOKIE['articulosPorPagina_mostrar'] : 5); ?>"
                    min="1" max="<?php echo $totalArticulos ; ?> ">

                    <button type="submit">Actualizar</button>
            </div>
            <div class="sort-buttons">
                <button type="submit" name="order" value="ASC" <?php echo (isset($_GET['order']) && $_GET['order'] == 'ASC') ? 'class="active"' : ''; ?>>A-Z</button>
                <button type="submit" name="order" value="DESC" <?php echo (isset($_GET['order']) && $_GET['order'] == 'DESC') ? 'class="active"' : ''; ?>>Z-A</button>

            </div>
            <div class="user-icon">
                <label  for ="dropdown">
                <?php
                    // PHP: Comprobar si el usuario ya tiene una imagen guardada
                    $profileImage = (!empty(isset($_SESSION['profile_image']))) ? $_SESSION['profile_image'] : $defaultImage;
                    ?>
                    <img src="<?php echo $profileImage; ?>" alt="Foto de perfil" id="userIcon">
                </label>
                <input hidden class="dropdown" type="checkbox" id="dropdown" name="dropdown" />
                <div class="section-dropdown">
                <?php if (isset($_SESSION['username'])): ?>
                        <a href="index.php?pagina=Perfil">Perfil <i class="uil uil-arrow-right"></i></a>
                        <?php if ($_SESSION['username'] === "admin"): ?>
                            <a href="index.php?pagina=Admin">Admin <i class="uil uil-arrow-right"></i></a>
                        <?php endif; ?>
                        <a href="index.php?pagina=MostrarInici&logout=1">Tancar Sessió <i class="uil uil-arrow-right"></i></a>
                    <?php else: ?>
                        <a href="index.php?pagina=Login">Iniciar Sessió <i class="uil uil-arrow-right"></i></a>
                        <a href="index.php?pagina=SignUp">Crear Compte <i class="uil uil-arrow-right"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        

    </div>
    </form>
    <div class="content">
    <?php
            // Obtener la página actual de la URL, por defecto es 1
            $paginaActual = validarEntero('page', 1, 1, ceil($totalArticulos / 1));
            $articulosPorPagina = validarEntero('articulosPorPagina', 5, 1, $totalArticulos); // Número de artículos por página
            $searchQuery = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; // Obtener la consulta de búsqueda

            echo mostrarArticulos('Mostrar', $paginaActual, (isset($_COOKIE['articulosPorPagina_Mostrar']) ? $_COOKIE['articulosPorPagina_Mostrar'] : $articulosPorPagina), $searchQuery);  // Usar el valor de artículos por página
            ?>
    </div>
    
</div>

    <!-- <?php
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


        </div>
    </div> -->
<!-- Modal -->
<div id="articleModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modalArticleContent"></div>
        </div>
    </div>
    
    <script>
    function readArticle(articleId) {
    fetch(`/Backend_Pt5/ajax/read_article.php?id=${articleId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalArticleContent').innerHTML = `
                <img src="${data.image}" alt="Imatge Article">
                <h4>${data.title}</h4>
                <p>${data.content}</p>
            `;
            var modal = document.getElementById("articleModal");
            modal.style.display = "block";
        })
        .catch(error => console.error('Error:', error));
    }   
   

    // Modal functionality
    var modal = document.getElementById("articleModal");
    var span = document.getElementsByClassName("close")[0];

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>
</body>

</html>