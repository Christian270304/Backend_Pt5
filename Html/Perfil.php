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
    $defaultImage = "https://storage.googleapis.com/a1aa/image/JLwi3piUzQY3G92u0CH63SjxE3kuf8lWqsoTZH7fYWfAkqWnA.jpg"; // URL predeterminada
    $profileImage = (!empty(isset($_SESSION['profile_image']))) ? $_SESSION['profile_image'] : $defaultImage;
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
                <form action="index.php?pagina=CambiarContra" method="POST">
                    <label for="public-email">Your password</label>
                        <!-- Botón para abrir el modal -->
                        <button class="open" id="openModal">Cambiar Contraseña</button>

                        <!-- El modal -->
                        <div id="myModal" class="modal">
                            <div class="modal-content">
                                <span class="close" id="closeModal">&times;</span>
                                <h2>Cambiar Contraseña</h2>
                                <form id="changePasswordForm" action="cambiar_contrasena.php" method="POST">
                                    <label for="old_password">Contraseña Actual:</label>
                                    <input type="password" id="old_password" name="old_password" required><br><br>

                                    <label for="new_password">Nueva Contraseña:</label>
                                    <input type="password" id="new_password" name="new_password" required><br><br>

                                    <label for="confirm_password">Confirmar Nueva Contraseña:</label>
                                    <input type="password" id="confirm_password" name="confirm_password" required><br><br>

                                    <button class="btn" type="submit">Guardar Cambios</button>
                                </form>
                            </div>
                        </div>
                    <small>
                        Aqui puedes cambiar tu contraseña
                    </small>
                </form>
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


        function previewImage(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const profileImage = document.getElementById('profile-image');
                profileImage.src = URL.createObjectURL(file);
                profileImage.onload = function() {
                    URL.revokeObjectURL(profileImage.src);
                };

                // Envía el formulario automáticamente al seleccionar la imagen
                document.getElementById('upload-form').submit();
            } else {
                alert("Por favor, selecciona un archivo de imagen válido.");
            }
        }
    </script>
</body>

</html>