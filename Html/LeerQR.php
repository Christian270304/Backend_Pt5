<!DOCTYPE html>
<html lang="cat">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Estilos/leerQR.css" rel="stylesheet">
    <title>Leer QR</title>
</head>
<body>
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
                        
                    </ul>
                </nav>
                <?php endif; ?>
                
            
        <div class="user-icon">
                <label  for ="dropdown">
                
                    <img src="" alt="Foto de perfil" id="userIcon">
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
        <h1>Leer QR</h1>
        <form action="index.php?pagina=LeerQR" method="post" enctype="multipart/form-data">
            <label for="qrImage">Sube una imagen de un código QR:</label>
            <input type="file" name="qrImage" id="qrImage" accept="image/*" required>
            <input type="submit" value="Leer QR">
        </form>
    </div>
    
</body>
</html>