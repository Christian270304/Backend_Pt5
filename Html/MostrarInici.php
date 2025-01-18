<!-- Christian Torres Barrantes -->
<!DOCTYPE html>
<html lang="cat">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
    <link href="Estilos/estilosInicio.css" rel="stylesheet">
    <!-- Icono básico en formato .ico -->
    <link rel="icon" href="Imagenes/favicon.ico" type="image/x-icon">
    <!-- Icono en formato PNG para navegadores modernos -->
    <link rel="icon" href="Imagenes/favicon.png" type="image/png" sizes="32x32">
    <!-- Icono para dispositivos Apple -->
    <link rel="apple-touch-icon" href="Imagenes/apple-touch-icon.png">
</head>

<body>
    <div class="container">
    <form method="get" action="">
        <div class="header">
            <div class="logo">
                <a href="index.php?pagina=MostrarInici">
                    <img src="images/favicon.png" alt="Logotip de la pàgina">
                </a>
            </div>
        
            <div class="search-bar">
                <input placeholder="Search..." type="text" />
            </div>
            <div class="articles-per-page">
            <label for="articulosPorPagina">Artículos por página:</label>
                <?php
                $totalArticulos = totArticles(); // Obtener el total de artículos
                ?>
                <input type="hidden" name="page" value="<?php echo isset($_GET['page']) ? (int)$_GET['page'] : 1; ?>">
                <input type="hidden" name="pagina" value="<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 'MostrarInici'; ?>">
                <input type="number" name="articulosPorPagina" id="articulosPorPagina"
                    value="<?php echo isset($_GET['articulosPorPagina']) ? $_GET['articulosPorPagina'] : 5; ?>"
                    min="1" max="12">
                <button type="submit">Actualizar</button>
            </div>
            <div class="sort-buttons">

            </div>
            <div class="user-icon">
                <label  for ="dropdown">
                    <img src="images/profile-user-account.svg" alt="User Icon" id="userIcon">
                </label>
                <input hidden class="dropdown" type="checkbox" id="dropdown" name="dropdown" />
                <div class="section-dropdown">
                <?php if (isset($_SESSION['username'])): ?>
                        <a href="index.php?pagina=Perfil">Perfil <i class="uil uil-arrow-right"></i></a>
                        <?php if ($_SESSION['username'] === "admin"): ?>
                            <a href="index.php?pagina=Admin">Admin <i class="uil uil-arrow-right"></i></a>
                        <?php endif; ?>
                        <!-- <a href="/logout">Tancar Sessió <i class="uil uil-arrow-right"></i></a> -->
                    <?php else: ?>
                        <a href="index.php?pagina=Login">Iniciar Sessió <i class="uil uil-arrow-right"></i></a>
                        <a href="index.php?pagina=SignUp">Crear Compte <i class="uil uil-arrow-right"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="content" id="articlesContainer">
        
                
            

            <?php
            // Obtener la página actual de la URL, por defecto es 1
            $paginaActual = validarEntero('page', 1, 1, ceil($totalArticulos / 1));
            $articulosPorPagina = validarEntero('articulosPorPagina', 5, 1, $totalArticulos); // Número de artículos por página

            echo mostrarTodosArticulos('MostrarInici', $paginaActual, $articulosPorPagina);  // Usar el valor de artículos por página
            ?>
        </div>
        </form>
    </div>


    <!-- <?php if (isset($_GET['expired']) && $_GET['expired'] == 1) {
        echo "<script>alert('Su sesión ha expirado por inactividad. Por favor, inicie sesión nuevamente.');</script>";
    } ?>
    <div class="container">
        <div class="menu">
            <div class="account-icon">
                <img src="Imagenes/account.svg" alt="Cuenta">
                <ul class="dropdown">
                    <li><a href="index.php?pagina=Login">Iniciar Sesión</a></li>
                    <li><a href="index.php?pagina=SignUp">Crear Cuenta</a></li>
                </ul>
            </div>
        </div>
        <div class="content">
            
        </div>
    </div> -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const accountIconBtn = document.getElementById('account-icon-btn');
            const accountIcon = document.querySelector('.account-icon');

            // Detectar si el dispositivo es móvil
            const isMobile = window.matchMedia("(max-width: 768px)").matches;

            // Configuración para dispositivos móviles
            if (isMobile) {
                accountIconBtn.addEventListener('click', function (event) {
                    event.preventDefault(); // Evita redirección en caso de usar `a` o `button`
                    event.stopPropagation();
                    accountIcon.classList.toggle('active'); // Alterna la clase active
                });

                // Cierra el menú desplegable si se hace clic fuera del icono
                document.addEventListener('click', function (event) {
                    if (!accountIcon.contains(event.target)) {
                        accountIcon.classList.remove('active');
                    }
                });
            }
        });
    </script>
</body>

</html>