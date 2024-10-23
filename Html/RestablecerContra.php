<!-- Christian Torres Barrantes -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
</head>
<body>
    <form action="index.php?pagina=Restablecer" method="POST">
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
        <label for="password1">Nueva Contraseña:</label>
        <input type="password" id="password1" name="password1" required>
        <br>
        <label for="password2">Confirma tu nueva contraseña:</label>
        <input type="password" id="password2" name="password2" required>
        <br>
        <button type="submit">Restablecer Contraseña</button>
    </form>
</body>
</html>