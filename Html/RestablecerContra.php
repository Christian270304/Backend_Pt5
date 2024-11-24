<!-- Christian Torres Barrantes -->
<!DOCTYPE html>
<html lang="cat">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilos/RestablecerContra.css">
    <title>Restablecer Contraseña</title>
</head>

<body>
    <div class="container">
        <h2>Restablecer Contraseña</h2>
        <form action="index.php?pagina=Restablecer" method="POST">
            <input type="hidden" name="token" value="<?php echo isset($_GET['token']) ? $_GET['token'] : (isset($token) ? $token : ""); ?>">
            <div class="field">
                <svg class="input-icon" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                    <path d="M80 192V144C80 64.47 144.5 0 224 0C303.5 0 368 64.47 368 144V192H384C419.3 192 448 220.7 448 256V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V256C0 220.7 28.65 192 64 192H80zM144 192H304V144C304 99.82 268.2 64 224 64C179.8 64 144 99.82 144 144V192z"></path>
                </svg>
                <input type="password" name="password1" class="input-field" placeholder="Nova Contrasenya" value="<?php echo isset($contra1) ? $contra1 : ""; ?>" required>
            </div>
            
            <div class="field">
                <svg class="input-icon" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                    <path d="M80 192V144C80 64.47 144.5 0 224 0C303.5 0 368 64.47 368 144V192H384C419.3 192 448 220.7 448 256V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V256C0 220.7 28.65 192 64 192H80zM144 192H304V144C304 99.82 268.2 64 224 64C179.8 64 144 99.82 144 144V192z"></path>
                </svg>
                <input type="password" name="password2" class="input-field" placeholder="Repetiu la Contrasenya" value="<?php echo isset($contra2) ? $contra2 : ""; ?>" required>
            </div>
            <button type="submit" class="btn">Restablecer Contraseña</button>
        </form>
        <?php
        // Mostrar mensajes de error y éxito
        echo mostrarMensaje(isset($error_message)? $error_message: "", 'error');
        echo mostrarMensaje(isset($success_message)? $success_message: "", 'success');
        ?>
        <?php if (!empty($success_message)): ?>
            <div id="countdown">Redirigiendo en <span id="timer">5</span> segundos...</div>
            
        <?php endif; ?>
    </div>
    <script>
        // Contador para redirigir después de un tiempo
        let timeLeft = 5; // Tiempo en segundos

        const countdownElement = document.getElementById('timer');
        const redirectInterval = setInterval(function() {
            timeLeft--;
            countdownElement.textContent = timeLeft; // Actualiza el contador en la página

            if (timeLeft <= 0) {
                clearInterval(redirectInterval); // Detiene el contador
                window.location.href = 'index.php?pagina=Login'; // Redirige al login
            }
        }, 1000); // Actualiza cada segundo
    </script>
</body>

</html>