<!-- Christian Torres Barrantes -->
<!DOCTYPE html>
<html lang="cat">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Estilos/Insertar.css" rel="stylesheet">
    <title>Insertar</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <a href="">
                    <img src="images/favicon.png" alt="Logotip de la pàgina">
                </a>
            </div>
            <?php if (isset($_SESSION['username'])): ?>
                <nav>
                    <ul>
                        <li><a href="index.php?pagina=Inicio" id="showAllArticles">Inici</a></li>
                        <li><a href="index.php?pagina=Mostrar" id="showMyArticles">Articles</a></li>
                        <li><a href="index.php?pagina=Insertar" id="newArticle">Crear Article</a></li>
                    </ul>
                </nav>
            <?php endif; ?>

            <div class="user-icon">
                <label for="dropdown">
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
        <div class="content">
            <div class="form">
                <div class="image-grid">
                    <div class="image-selector">
                        <div class="profile-picture">
                            <img id="profile-image" alt="Foto de perfil" height="100" src="<?php echo $profileImage; ?>" />
                            <div class="edit-button" onclick="document.getElementById('file-input').click()">
                                <button class="fas fa-pencil-alt"></button>Edit 🖋️
                            </div>
                        </div>
                    </div>
                </div>
                <div class="titol-grid-containter">
                 <div class="text-fields">
                    <input placeholder="Titulo" type="text"/>
                </div>   
                </div>
                <div class="cuerpo-grid-containter">
                    <div class="text-fields">
                        <textarea placeholder="Cuerpo"></textarea>
                    </div>   
                </div>
                <form id="upload-form" action="index.php?pagina=SubirImagen" method="post" enctype="multipart/form-data">
                <input type="file" id="file-input" name="article_image" accept="image/*" onchange="previewImage(event)">
                <button type="submit" style="display: none;"></button> <!-- Botón oculto para activar la carga -->
            </form>
            </div>
        </div>
    </div>




    <!-- 
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
            <h1>Introduce un Articulo</h1>
            <form class="formulario" method="POST" action="index.php?pagina=Insertar">
                <div class="contenido">
                    <label>
                        <h1>Titol</h1>
                    </label>
                    <input type="text" id="titulo" value="<?php echo isset($titulo) ? $titulo : ''; ?>" name="titulo" class="campos">
                    <label>
                        <h1>Cos</h1>
                    </label>
                    <textarea id="cuerpo" name="cuerpo" class="mensaje"><?php echo isset($cuerpo) ? $cuerpo : ''; ?></textarea>
                    <?php echo isset($mostrar) ? $mostrar : '' ?>
                    <button class="btn" type="submit" name="boton">Enviar</button>
                </div>
            </form>
        </div>

    </div> -->

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const profileImage = document.getElementById('profile-image');
            profileImage.src = file;
            document.getElementById('upload-form').submit();

        }
    </script>
</body>

</html>