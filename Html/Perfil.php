<!-- Christian Torres Barrantes -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Estilos/Perfil.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <title>Perfil</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">
            </div>
            <nav>
                <ul>
                    <li><a href="index.php?pagina=Inicio">Inici</a></li>
                    <li><a href="index.php?pagina=Mostrar">Articles</a></li>
                    <li><a href="index.php?pagina=Insertar">Insertar Article</a></li>
                </ul>
            </nav>
            <div class="user-icon">
                <label for="dropdown">
                    <?php
                    // Iniciar la sesión
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    // PHP: Comprobar si el usuario ya tiene una imagen guardada
                    $profileImage = (!empty(isset($_SESSION['profile_image']))) ? $_SESSION['profile_image'] : $defaultImage;
                    ?>
                    <img src="<?php echo $profileImage; ?>" alt="Foto de perfil" id="userIcon">
                </label>
                <input hidden class="dropdown" type="checkbox" id="dropdown" name="dropdown" />
                <div class="section-dropdown">
                    <?php if (isset($_SESSION['username'])): ?>
                        <?php if ($_SESSION['username'] === "admin"): ?>
                            <a href="index.php?pagina=Admin">Admin <i class="uil uil-arrow-right"></i></a>
                        <?php endif; ?>
                        <a href="index.php?pagina=MostrarInici&logout=1">Tancar Sessió <i class="uil uil-arrow-right"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="content">
            <h1>Perfil de Usuario</h1>
            <?php if (!empty($mostrar)) {
                echo $mostrar;
            } ?>
            <div class="profile-section">
                <div class="form-group">
                    <label for="name">Username</label>
                    <form action="index.php?pagina=ChangeUsername" method="POST">
                        <?php if (mostrarPassword() != ""): ?>
                            <input id="name" placeholder="" name="username" type="text" value="<?php echo $_SESSION['username'] ?>" />
                            <button>Save</button>
                        <?php else: ?>
                            <input id="name" placeholder="" type="text" readonly value="<?php echo $_SESSION['username'] ?>" />
                        <?php endif; ?>
                    </form>
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
                <form action="index.php?pagina=ChangeEmail" method="POST">
                    <?php if (mostrarPassword() != ""): ?>
                        <input id="email" placeholder="" name="email" type="email" value="<?php echo mostrarEmail(); ?>" />
                        <button>Save</button>
                    <?php else: ?>
                        <input id="email" placeholder="" type="email" readonly value="<?php echo mostrarEmail(); ?>" />
                    <?php endif; ?>
                </form>
                <small>
                    Este es tu email con el que te has registrado.
                </small>
            </div>
            <div class="form-group">
                <label for="public-email">Your password</label>
                <!-- Botón para abrir el modal -->
                <?php if (mostrarPassword() != ""): ?>
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
                                    <input type="password" id="old_password" name="old_password" value="<?php echo isset($contraAntigua) ? $contraAntigua : "" ?>"><br><br>
                                    <input hidden type="checkbox" id="showPassword" onclick="togglePassword('old_password','icono')">
                                    <label for="showPassword" id="icono" class="password-toggle"><i class="fi fi-rr-eye"></i></label>
                                </div>

                                <div class="password-container">
                                    <label for="new_password">Nueva Contraseña:</label>
                                    <input type="password" id="new_password" name="new_password" value="<?php echo isset($contraNueva) ? $contraNueva : "" ?>"><br><br>
                                    <input hidden type="checkbox" id="showPassword2" onclick="togglePassword('new_password','icono1')">
                                    <label for="showPassword2" id="icono1" class="password-toggle"><i class="fi fi-rr-eye"></i></label>
                                </div>

                                <div class="password-container">
                                    <label for="confirm_password">Confirmar Nueva Contraseña:</label>
                                    <input type="password" id="confirm_password" name="confirm_password" value="<?php echo isset($contraNueva2) ? $contraNueva2 : "" ?>"><br><br>
                                    <input hidden type="checkbox" id="showPassword3" onclick="togglePassword('confirm_password','icono2')">
                                    <label for="showPassword3" id="icono2" class="password-toggle"><i class="fi fi-rr-eye"></i></label>
                                </div>

                                <?php if (!empty($errores)) {
                                    echo $errores;
                                } ?>
                                <button class="btn" type="submit">Guardar Cambios</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                <small>
                    Aqui puedes cambiar tu contraseña
                </small>
            </div>
            <div class="form-group">
                <form action="index.php?pagina=ChangeBio" method="POST">
                    <label for="bio">
                        Bio
                    </label>
                    <textarea id="bio" name="bio" placeholder="Explica un poco sobre ti"><?php echo mostrarBio(); ?></textarea>
                    <small>
                        Aqui puedes escribir sobre ti.
                    </small>
                    <button>Save</button>
                </form>
            </div>
            <div class="buttons-container">
                <!-- Botón para cerrar la sesion -->
                <button class="logout-btn"><a href="index.php?pagina=MostrarInici&logout=1">Cerrrar Sesion</a></button>
                <!-- Botón para generar el código QR -->
                <button id="generate-qr-btn" class="generate-qr-btn">Generar QR</button>

                <!-- Botón para generar token de la api -->
                <button id="generate-token-btn" class="generate-token-btn">Generar Token</button>
            </div>


            <!-- Contenedor para mostrar el código QR -->
            <div id="qr-code-overlay">
                <div id="qr-code-container">
                    <img id="qr-code-image" src="" alt="Código QR">
                </div>
            </div>

            <!-- Contenedor para mostrar el token -->
            <div id="token-overlay">
                <div id="token-container">
                    <label for="token">Token</label>
                    <h3 id="token"></h3><br>
                    <label for="refreshtoken">Refresh Token</label>
                    <h3 id="refreshtoken"></h3><br><br>
                    <small>No compartir los tokens</small>
                </div>
                <div id="refreshtoken-container">
                    
                </div>
            </div>

            <!-- Input oculto para cargar la imagen -->
            <input type="file" id="file-input" accept="image/*" onchange="loadImage(event)">
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

        function togglePassword(tipo, cos) {
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
            profileImage.src = URL.createObjectURL(file);
            document.getElementById('upload-form').submit();

        }
        document.getElementById('generate-qr-btn').addEventListener('click', function() {
            // Obtener el contenedor del código QR
            var qrImage = document.getElementById('qr-code-image');
            var qrOverlay = document.getElementById('qr-code-overlay');
            const username = '<?php echo $_SESSION['username']; ?>';
            const url = `https://ctorres.cat/index.php?pagina=Login&username=${encodeURIComponent(username)}`;
            fetch(`/Backend_Pt5/generate_qr.php?text=${encodeURIComponent(url)}`)
                .then(response => response.json())
                .then(data => {
                    qrImage.src = data.url;
                    qrOverlay.style.display = 'flex';
                });
        });

        // Cerrar el overlay cuando se hace clic fuera del código QR
        document.getElementById('qr-code-overlay').addEventListener('click', function(event) {
            if (event.target === this) {
                this.style.display = 'none';
            }
        });
        // Generar token para la api
        document.getElementById('generate-token-btn').addEventListener('click', function() {
            // Obtener el contenedor del código QR
            var token = document.getElementById('token');
            var refreshtoken = document.getElementById('refreshtoken');
            var tokenOverlay = document.getElementById('token-overlay');
            
            fetch(`/Backend_Pt5/index.php?pagina=Tokens`, {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                token.innerHTML = data.token;
                refreshtoken.innerHTML = data.refreshToken;
                tokenOverlay.style.display = 'flex';

                // Guardar el refresh token en la base de datos
                fetch(`/Backend_Pt5/index.php?pagina=GuardarRefreshToken`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ refreshToken: data.refreshToken })
                });
            });
        });

        // Cerrar el overlay cuando se hace clic fuera del Token
        document.getElementById('token-overlay').addEventListener('click', function(event) {
            if (event.target === this) {
                this.style.display = 'none';
            }
        });
    </script>
</body>

</html>