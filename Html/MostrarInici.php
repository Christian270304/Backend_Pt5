<!-- Christian Torres Barrantes -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
    <link href="Estilos/estilosInicio.css" rel="stylesheet">
</head>
<body>
<?php if (isset($_GET['expired']) && $_GET['expired'] == 1) {   
            echo "<script>alert('Su sesión ha expirado por inactividad. Por favor, inicie sesión nuevamente.');</script>";
        }?>
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
            <form method="get" action="">
                <label for="articulosPorPagina">Artículos por página:</label>
                <?php
                $totalArticulos = totArticles(); // Obtener el total de artículos
                ?>
                <input type="hidden" name="page" value="<?php echo isset($_GET['page']) ? (int)$_GET['page'] : 1; ?>">
                <input type="hidden" name="pagina" value="<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 'MostrarInici'; ?>">
                <input type="number" name="articulosPorPagina" id="articulosPorPagina" 
                    value="<?php echo isset($_GET['articulosPorPagina']) ? $_GET['articulosPorPagina'] : 5; ?>" 
                    min="1" max="<?php echo $totalArticulos; ?>">
                <button type="submit">Actualizar</button>
            </form>

            <?php
            // Obtener la página actual de la URL, por defecto es 1
            $paginaActual = validarEntero('page', 1, 1, ceil($totalArticulos / 1));
            $articulosPorPagina = validarEntero('articulosPorPagina', 5, 1, $totalArticulos); // Número de artículos por página

            echo mostrarTodosArticulos(false, 'MostrarInici' , $paginaActual, $articulosPorPagina);  // Usar el valor de artículos por página
            ?>
        </div>
    </div>
</body>
</html>