<?php
    // Christian Torres Barrantes
    require_once 'Model/Login.php';
   

    /**
 * Función que verifica los datos cuando el usuario intenta loguear.
 * @param string $user Nombre de usuario.
 * @param string $password Contraseña del usuario.
 * @param string $recaptcha Respuesta del reCAPTCHA.
 */
function loginDatos($user, $password, $recaptcha, $rememberMe, $QR) {
    if ($QR == "") {
        $booleanQR = false;
    } else {
        $booleanQR = true;
    }
    
    $defaultImage = "images/profile-user-account.svg";
    $recaptchaSecret = CLAVE_SECRETA;
    $showRecaptcha = false; 
    // Inicializar mensajes de error
    $mensajes = [];

    // Sanitizar y validar inputs
    $username = sanitizeInput($user);
    $contra = sanitizeInput($password);
    $mensajes = validateInputs($username, $contra);

    // Inicializar intentos de login
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;  
    }
    
    // Verificar si se debe mostrar el reCAPTCHA
    $showRecaptcha = $_SESSION['login_attempts'] >= 2;
    
    // Verificar reCAPTCHA si es necesario
    if ($_SESSION['login_attempts'] == 3) {
        if ($showRecaptcha && empty($mensajes)) {
            if (!isRecaptchaValid($recaptchaSecret, $recaptcha)) {
                $mensajes[] = "Si us plau, verifica que no ets un robot";
            }
        }
    }
    
    // Solo continuamos si no hay errores previos
    if (empty($mensajes)) {
        $result = buscarUsuario($username);
        $mensajes = handleLogin($result, $contra, $defaultImage, $rememberMe, $booleanQR, $QR);
    }

    // Mostrar errores si existen
    $mensaje = formatErrorMessages($mensajes);
    include 'Html/Login.php';
}

/**
 * Sanitiza la entrada del usuario.
 * @param string $input Entrada del usuario.
 * @return string Entrada sanitizada.
 */
function sanitizeInput($input) {
    return isset($input) ? trim(htmlspecialchars($input)) : '';
}

/**
 * Valida los inputs del usuario.
 * @param string $username Nombre de usuario.
 * @param string $password Contraseña del usuario.
 * @return array Mensajes de error.
 */
function validateInputs($username, $password) {
    $mensajes = [];
    if (empty($username)) {
        $mensajes[] = "El camp de l'usuari no pot estar buit";
    }
    if (empty($password)) {
        $mensajes[] = "El camp de la contrasenya no pot estar buit";
    }
    return $mensajes;
}

/**
 * Verifica si el reCAPTCHA es válido.
 * @param string $recaptchaSecret Clave secreta de reCAPTCHA.
 * @param string $recaptchaResponse Respuesta del reCAPTCHA.
 * @return bool Verdadero si es válido, falso de lo contrario.
 */
function isRecaptchaValid($recaptchaSecret, $recaptchaResponse) {
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}");
    $responseKeys = json_decode($response, true );
    return intval($responseKeys["success"]) === 1;
}

/**
 * Manejo del proceso de inicio de sesión.
 * @param array|null $result Resultado de la búsqueda del usuario.
 * @param string $contra Contraseña ingresada por el usuario.
 * @param string $defaultImage Imagen de perfil por defecto.
 * @return array Mensajes de error.
 */
function handleLogin($result, $contra, $defaultImage, $rememberMe, $booleanQR, $QR) {
    $mensajes = [];
    
    if ($result) {
        if (password_verify($contra, $result['password'])) {
            // Iniciar la sesión
            $_SESSION['username'] = $result['username'];
            $_SESSION['profile_image'] = file_exists($result['ruta_imagen']) ? $result['ruta_imagen'] : $defaultImage;
            
            // Opción "Remember Me"
            if ($rememberMe === 'on') {
                $token = bin2hex(random_bytes(32)); // Generar un token único
                guardarToken($result['id'], $token); // Almacenar el token en la base de datos
                if (setcookie('session_token', $token, time() + (30 * 24 * 60 * 60), "/")) {
                    echo "Cookie creada exitosamente.";
                } else {
                    echo "Error al crear la cookie.";
                }
            }
            if ($booleanQR) {
                header("Location: index.php?pagina=UserProfile&username=" . $QR);
            } else {
                header("Location: index.php?pagina=Mostrar");
            }
            
        } else {
            $_SESSION['login_attempts']++;
            $mensajes[] = "Contrasenya incorrecta";
        }
    } else {
        $mensajes[] = "Usuari no trobat";
    }
    return $mensajes;
}

/**
 * Formatea los mensajes de error en un solo string.
 * @param array $mensajes Mensajes de error.
 * @return string Mensajes de error formateados.
 */
function formatErrorMessages($mensajes) {
    return !empty($mensajes) ? implode('<br/>', $mensajes) : '';
}

function validarTokenRememberMe($token) {
    $result = buscarUsuarioPorToken($token);
    return $result;
    
}
    
?>