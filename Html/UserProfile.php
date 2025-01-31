<!DOCTYPE html>
<html lang="cat">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/Backend_Pt5/Estilos/UserProfile.css" rel="stylesheet">
    <title>User-Profile</title>
</head>

<body><div class="header">
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
        
        <!-- Perfil del Usuario -->
        <div class="user-profile">
            <img src="path/to/profile-picture.jpg" alt="" class="profile-picture">
            
            <?php
                require_once 'conexion.php';
                global $conn;
                $username = isset($_GET['username']) ? $_GET['username'] : "";
                $sql = "SELECT * FROM users WHERE username = :username";
                $statement = $conn->prepare($sql);
            $statement->bindParam(':username', $username, PDO::PARAM_STR);
            $statement->execute();
            $resultado = $statement->fetch();
            ?>
            <div class="header-profile">
                <img alt="Foto de perfil" height="80" src="<?php if($resultado['ruta_imagen'] == null) { 
                    echo "/Backend_Pt5/images/profile-user-account.svg";
                } else {
                    echo "/Backend_Pt5/" . $resultado['ruta_imagen'];

                } 
                ?>" width="80" />
                <div class="info">
                <h1 class="username"><?= $resultado['username']  ?></h1>
                    <p><?= $resultado['email'] ?></p>
                    <p class="bio">Esta es la biografía del usuario. Aquí puedes escribir algo sobre ti.</p><br>
                    <div class="stats">
                        <div>
                            <p>454</p>
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
                
            
            <!-- Aquí se generarán los artículos del usuario -->
            <?php
            
            global $conn;
            $username = isset($_GET['username']) ? $_GET['username'] : "";
            $query = "SELECT articles.*
                        FROM articles
                        INNER JOIN users ON articles.user_id = users.id
                        WHERE users.username = :username";
            $statement = $conn->prepare($query);
            $statement->bindParam(':username', $username, PDO::PARAM_STR);
            $statement->execute();
            $resultado = $statement->fetchAll();
            $articles = [];
            foreach ($resultado as $row) {
                $articles[] = [
                    'id' => $row['id'],
                    'titol' => $row['titol'],
                    'cos' => $row['cos'],
                    'ruta_imagen' => $row['ruta_imagen']
                ];
            }
            // Ejemplo de generación de artículos en PHP
            for ($i = 0; $i < count($articles); $i++) {
                $article = $articles[$i];


                echo '<div class="card" id="' . $article['id'] . '">';
                echo '<img class="img-article" src="/Backend_Pt5/' . $article['ruta_imagen'] . '" alt="Imagen de ' . $article['titol'] . '">';
                echo '<div class="article-content">';
                echo '<h4 class="titulo">' . $article['titol'] . '</h4>';
                echo '<p class="texto">' . $article['cos'] . '</p>';
                echo '</div>';
                echo '</div>';
            }
            ?>
            </div>
        </div>
    </div>
</body>

</html>