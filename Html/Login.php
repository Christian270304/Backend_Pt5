<!-- Christian Torres Barrantes -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Estilos/Login.css" rel="stylesheet">
    <title>Iniciar Sesion</title>
</head>

<body>
    <div>
        <a href="index.php?pagina=MostrarInici"><button class="salir"></button></a>
    </div>
    <div class="card">
        <h4 class="title">Iniciar Sesion</h4>
              
        
        <form method="POST" action="index.php?pagina=Login">
            <div class="field">
            <svg class="input-icon" width="800px" height="800px" viewBox="0 0 24 24" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{stroke-miterlimit:10;stroke-width:1.91px;}</style></defs><circle class="cls-1" cx="12" cy="7.25" r="5.73"/><path class="cls-1" d="M1.5,23.48l.37-2.05A10.3,10.3,0,0,1,12,13h0a10.3,10.3,0,0,1,10.13,8.45l.37,2.05"/></svg>
                <input autocomplete="off" id="logemail" placeholder="Username" class="input-field" name="username" type="namespace" value="<?php echo isset($username) ? $username : ''; ?>">
            </div>
            <div class="field">
                <svg class="input-icon" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                    <path d="M80 192V144C80 64.47 144.5 0 224 0C303.5 0 368 64.47 368 144V192H384C419.3 192 448 220.7 448 256V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V256C0 220.7 28.65 192 64 192H80zM144 192H304V144C304 99.82 268.2 64 224 64C179.8 64 144 99.82 144 144V192z"></path>
                </svg>
                <input autocomplete="on" id="logpass" placeholder="Contraseña" class="input-field" name="contra" type="password" value="<?php echo isset($contra) ? $contra : ''; ?>">
            </div>
            <div class="errors">
                <?php echo isset($mensaje) ? $mensaje : '' ?>
            </div>
            <label>
        <input type="checkbox" name="remember_me"> Recuérdame
    </label><br><br>
            <button class="btn" type="submit">Entrar</button>
            <a href="index.php?pagina=SignUp" class="btn-link">No tengo cuenta 😔</a>
            <a href="index.php?pagina=RecuperarContra" class="btn-link">Te has olvidado la contraseña?</a>
        </form>
    </div>
</body>

</html>