<!-- Christian Torres Barrantes -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificacion</title>
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
                <li><a href="index.php?pagina=Mostrar"><img class="icon" src="Imagenes/newspaper.svg"><span>Articles</span></a></li>
                <li><a href="index.php?pagina=Insertar"><img class="icon" src="Imagenes/add-square.svg"><span>Insertar Article</span></a></li>
                <li><a href="index.php?pagina=Borrar"><img class="icon" src="Imagenes/delete-button.svg"><span>Borrar Article</span></a></li>
                <li><a href="index.php?pagina=Modificar"><img class="icon" src="Imagenes/edit.svg"><span>Modificar Article</span></a></li>
            </ul>
        </nav>
        </div>
        
        <div class="content">
            <form class="formulario" method="POST" action="index.php?pagina=BorrarVerificar">
                <div class="contenido">
                    <label><h1>Seguro que quiere borrar este articulo?</h1></label>
                    <input readonly type="text" id="titulo" value="<?php echo $titol; ?>" name="titulo" class="campos">
                    <textarea readonly id="cuerpo" name="cuerpo" class="mensaje"><?php echo $cos; ?></textarea>
                    <?php  echo $mensaje?>
                    <div class="botones-contenedor">
                        <button class="btn" type="submit" name="boton" value="Si">Borrar</button>   
                        <button class="btn" type="submit" name="boton" value="No">Cancelar</button> 
                    </div>    
                </div>
            </form>
        </div>
    
    </div>
    
</body>
</html>


