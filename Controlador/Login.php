<?php
    // Christian Torres Barrantes
    require_once 'Model/Login.php';

    /**
     * Funcion que verifica los datos cuando el usuario se intena loguear.
     * @user Parametro que nos indica el username del usuario.
     * @password Parametro que nos indica la contraseña del usuario.
     */
    function loginDatos($user, $password,$recaptcha) {
        $defaultImage = "Imagenes/profile-user.svg";
        $recaptchaSecret = CLAVE_SECRETA;
        $recaptchaResponse = $recaptcha;
        // Verifica si el token de reCAPTCHA es válido
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaResponse}");
        $responseKeys = json_decode($response, true);
        $mensajes = array();
        $mensaje = '';
    
        // Validar inputs
        $username = isset($user) ? trim(htmlspecialchars($user)) : '';
        $contra = isset($password) ? trim(htmlspecialchars($password)) : '';

       
    
        if (empty($username)) {
            $mensajes[] = "El camp del correu no pot estar buit";
        }
    
        if (empty($contra)) {
            $mensajes[] = "El camp de la contrasenya no pot estar buit";
        }
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;  
        }

        $showRecaptcha = $_SESSION['login_attempts'] >= 3;
        // Solo continuamos si no hay errores previos
        if (empty($mensajes)) {
            $result = buscarUsuario($username);
            if ($result) {
                if (password_verify($contra, $result['password'])) {
                    // Iniciar la sesión
                    if ($responseKeys["success"] || !$showRecaptcha) {
                        $_SESSION['username'] = $result['username'];
                    $_SESSION['profile_image'] = file_exists($result['ruta_imagen']) ? $result['ruta_imagen'] : $defaultImage;
                    
                    // opción "Remember Me"
                    if (isset($_POST['remember_me'])) {
                        // Generar un token único
                        $token = bin2hex(random_bytes(32)); // 64 caracteres hexadecimales

                        // Almacenar el token en la base de datos
                        guardarToken($result['id'], $token);

                        // Configurar cookie con el token
                        setcookie('session_token', $token, time() + (30 * 24 * 60 * 60), "/"); // Cookie válida por 30 días
                    }
    
                    header("Location: index.php?pagina=Mostrar");
                    exit;
                    } else {
                        $mensajes[] = "Check the reCAPTCHA";
                    }
                      
                } else {
                    $_SESSION['login_attempts']++;
                    $mensajes[] = "Contrasenya incorrecta";
                    
                }
            } else {
                $mensajes[] = "Usuario no trobat";
            }
        }
        
        
        // Mostrar errores si existen
        if (!empty($mensajes)) {
            foreach ($mensajes as $errors) {
                $mensaje .= $errors . '<br/>';
            }
        }
    
        include 'Html/Login.php';
    }

    
?>