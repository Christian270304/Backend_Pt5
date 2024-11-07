<!-- Christian Torres Barrantes -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Estilos/Perfil.css" rel="stylesheet">
    <title>Perfil</title>
</head>

<body>
    <?php
    // PHP: Comprobar si el usuario ya tiene una imagen guardada
    $defaultImage = "Imagenes/profile-user.svg"; // URL predeterminada
    $profileImage = (file_exists(!empty(isset($_SESSION['profile_image'])))) ? $_SESSION['profile_image'] : $defaultImage;
    ?>
    <div class="container">
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
            <h1>Perfil de Usuario</h1>
            <?php if (!empty($mostrar)) {echo $mostrar;}?>
            <div class="profile-section">
                <div class="form-group">
                    <label for="name">Username</label>
                    <input id="name" placeholder="" type="text" value="<?php echo $_SESSION['username'] ?>" />
                    <small>
                        Este es tu username con el cual inicias sesion.
                    </small>
                </div>
                <div class="profile-picture">
                    <img id="profile-image" alt="Foto de perfil" height="100" src="<?php echo $profileImage; ?>" />
                    <div class="edit-button" onclick="document.getElementById('file-input').click()">
                        <i class="fas fa-pencil-alt"></i>Edit 🖋️
                    </div>
                </div>
                
            </div>
            <form id="upload-form" action="index.php?pagina=SubirImagen" method="post" enctype="multipart/form-data">
                <input type="file" id="file-input" name="profile_image" accept="image/*" onchange="previewImage(event)">
                <button type="submit" style="display: none;"></button> <!-- Botón oculto para activar la carga -->
            </form>
            <div class="form-group">
                <label for="public-email">Your email</label>
                <input id="email" placeholder="" type="email" readonly value="<?php echo mostrarEmail(); ?>" />
                <small>
                    Este es tu email con el que te has registrado.
                </small>
            </div>
            <div class="form-group">
                    <label for="public-email">Your password</label>
                        <!-- Botón para abrir el modal -->
                        <button class="open" id="openModal">Cambiar Contraseña</button>

                        <!-- El modal -->
                        <div id="myModal" class="modal">
                            <div class="modal-content">
                                <div class="header">
                                    <h2>Cambiar Contraseña</h2>
                                    <span class="close" id="closeModal">&times;</span>
                                </div>
                                <form id="changePasswordForm" action="index.php?pagina=CambiarContra" method="POST">
                                    <div class="password-container">
                                        <label for="old_password">Contraseña Actual:</label>
                                        <input type="password" id="old_password" name="old_password" value="<?php echo isset($contraAntigua)?>" ><br><br>
                                        <input hidden type="checkbox" id="showPassword" onclick="togglePassword('old_password','icono')">
                                        <label for="showPassword" id="icono" class="password-toggle"><i class="fi fi-rr-eye"></i></label>
                                    </div>
                                    
                                    <div class="password-container">
                                    <label for="new_password">Nueva Contraseña:</label>
                                    <input type="password" id="new_password" name="new_password" value="<?php echo isset($contraNueva)?>"><br><br>
                                        <input hidden type="checkbox" id="showPassword2" onclick="togglePassword('new_password','icono1')">
                                        <label for="showPassword2" id="icono1" class="password-toggle"><i class="fi fi-rr-eye"></i></label>
                                    </div>

                                    <div class="password-container">
                                    <label for="confirm_password">Confirmar Nueva Contraseña:</label>
                                    <input type="password" id="confirm_password" name="confirm_password" value="<?php echo isset($contraNueva2)?>"><br><br>
                                        <input hidden type="checkbox" id="showPassword3" onclick="togglePassword('confirm_password','icono2')">
                                        <label for="showPassword3" id="icono2" class="password-toggle"><i class="fi fi-rr-eye"></i></label>
                                    </div>
                                    
                                    

                                    
                                    <?php if (!empty($errores)) {echo $errores;}?>
                                    <button class="btn" type="submit">Guardar Cambios</button>
                                </form>
                            </div>
                        </div>
                    <small>
                        Aqui puedes cambiar tu contraseña
                    </small>
            </div>
            <div class="form-group">
                <label for="bio">
                    Bio
                </label>
                <textarea id="bio" placeholder="Explica un poco sobre ti"></textarea>
                <small>
                    Aqui puedes escribir sobre ti.
                </small>
            </div>
            <button class="button logout"><a href="index.php?pagina=MostrarInici">Cerrrar Sesion</a></button>
            <!-- Input oculto para cargar la imagen -->
            <input  type="file" id="file-input" accept="image/*" onchange="loadImage(event)">
        </div>
    </div>
    <script>
        // Obtener el modal
        var modal = document.getElementById("myModal");

        // Obtener el botón que abre el modal
        var btn = document.getElementById("openModal");

        // Obtener el elemento <span> que cierra el modal
        var span = document.getElementById("closeModal");

        // Cuando el usuario hace clic en el botón, abrir el modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // Cuando el usuario hace clic en <span> (x), cerrar el modal
        span.onclick = function() {
            modal.style.display = "none";
        }


        document.addEventListener('DOMContentLoaded', function() {
            <?php if (!empty($errores)): ?>
                // Abre el modal automáticamente si hay errores de validación
                modal.style.display = "block";
            <?php endif; ?>
        });

        function togglePassword(tipo,cos) {
            const passwordField = document.getElementById(tipo);
            const icono = document.getElementById(cos);
            // Cambia el tipo del campo entre "password" y "text"
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icono.innerHTML = '<i class="fi fi-rr-eye-crossed"></i>';
            } else {
                passwordField.type = "password";
                icono.innerHTML = '<i class="fi fi-rr-eye"></i>';
            }
        }

        function previewImage(event) {
            const file = event.target.files[0];
            const profileImage = document.getElementById('profile-image');
            profileImage.src = file;
            document.getElementById('upload-form').submit();
            
        }
    </script>
</body>

</html>