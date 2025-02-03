<!DOCTYPE html>
<html lang="cat">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/Backend_Pt5/Estilos/UserProfile.css" rel="stylesheet">
    <title>User-Profile</title>
</head>

<body>
    <div class="header">
            <div class="logo">
                <a href="">
                    <img src="/Backend_Pt5/images/favicon.png" alt="Logotip de la pàgina">
                </a>
            </div>
            <?php

            if (isset($_SESSION['username'])): ?>
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
                    $defaultImage = "/Backend_Pt5/Imagenes/profile-user.svg"; // URL predeterminada
                    $profileImage = (!empty(isset($_SESSION['profile_image']))) ? $_SESSION['profile_image'] : $defaultImage;
                    ?>
                    <img src="/Backend_Pt5/<?php echo $profileImage; ?>" alt="Foto de perfil" id="userIcon">
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
    <div class="container">
        <?php if (!(isset($error))):?>
        <!-- Perfil del Usuario -->
        <div class="user-profile">
            <img src="path/to/profile-picture.jpg" alt="" class="profile-picture">
            
            <div class="header-profile">
                <img alt="Foto de perfil" height="80" src="
                <?php if($resultado['ruta_imagen'] == null) { 
                    echo "/Backend_Pt5/images/profile-user-account.svg";
                } else {
                    echo "/Backend_Pt5/" . $resultado['ruta_imagen'];

                } 
                ?>" width="80" />
                <div class="info">
                <h1 class="username"><?= $resultado['username']  ?></h1>
                    <p><?= $resultado['email'] ?></p>
                    <p class="bio"><?= $resultado['bio'] ?></p><br>
                    <div class="stats">
                        <div>
                            <p><?= count($articles)?></p>
                            <p>publicaciones</p>
                        </div>
                        <div>
                            <p>15,6 mil</p>
                            <p>seguidores</p>
                        </div>
                        <div>
                            <p>81</p>
                            <p>seguidos</p>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
            <div class="tabs">
                <div >PUBLICACIONS</div>
            </div>
        <div class="content">

            
            <div class="gallery">
            <?=
            formatoArticulos($articles);
            ?>
            </div>
        </div>
        <?php else: ?>
            <h1><?= $error ?></h1>
        <?php endif; ?>
    </div>
</body>

</html>