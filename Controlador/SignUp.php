<?php
    // Christian Torres Barrantes
    require_once 'Model/SignUp.php';


    /*
    
    */
    function verificarDatos($username, $correo, $password1, $password2) {
        $mensajes = array();
        $mensaje = '';
    
        $username = isset($username) ? trim(htmlspecialchars($username)) : '';
        $correo = isset($correo) ? trim(htmlspecialchars($correo)) : '';
        $contra1 = isset($password1) ? trim(htmlspecialchars($password1)) : '';
        $contra2 = isset($password2) ? trim(htmlspecialchars($password2)) : '';
    
        // Validación de campos vacíos
        if (empty($username)) {
            $mensajes[] = "El camp del Username no pot estar buit";
        }
    
        if (empty($correo)) {
            $mensajes[] = "El camp del correu no pot estar buit";
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $mensajes[] = 'El camp del correu no és vàlid';
        }
    
        if (empty($contra1)) {
            $mensajes[] = "El camp de la contrasenya no pot estar buit";
        } else if (empty($contra2)) {
            $mensajes[] = "Por favor repita la contraseña";
        }
    
        // Verificar si el usuario o correo ya existen
        $result = usrExist($username, $correo);
        if ($result > 0) {
            $mensajes[] = "El nom d'usuari o el correu ja estan registrats";
        }
        // Si no hay mensajes de error hasta ahora, continuamos con la validación de las contraseñas
        if (empty($mensajes)) {
            if ($contra1 == $contra2) {
                // Validar que la contraseña sea fuerte
                if (validarContraseña($contra1)) {
                    // Encriptar la contraseña
                    $hashed_password = password_hash($contra1, PASSWORD_DEFAULT);
    
                    // Insertar el usuario
                    $stmt = insertarUsuario($username, $correo, $hashed_password);
                    if ($stmt) {
                        // Redirigir a la página de login si todo sale bien
                        header("Location: index.php?pagina=Login");
                        exit();
                    } else {
                        $mensajes[] = "Error en registrar l'usuari";
                    }
                } else {
                    // Mensaje si la contraseña no es fuerte
                    $mensajes[] = "La contrasenya ha de contenir:<br/> - Un mínim de 8 caràcters. <br/> - Una lletra majúscula. <br/> - Una lletra minúscula. <br/> - Un nombre. <br/> - I un caràcter especial.";
                }
            } else {
                $mensajes[] = "Les contrasenyes no coincideixen";
            }
        }
    
        // Mostrar mensajes de error si los hay
        if (!empty($mensajes)) {
            foreach ($mensajes as $errors) {
                $mensaje .= $errors . '<br/>';
            }
        }
    
        // Incluir el formulario de registro nuevamente con los mensajes de error
        include 'Html/SignUp.php';
    }


    function validarContraseña($password) {
        // Requisitos de la contraseña
        $longitudMinima = 8;
        $tieneMayuscula = preg_match('/[A-Z]/', $password);
        $tieneMinuscula = preg_match('/[a-z]/', $password);
        $tieneNumero = preg_match('/\d/', $password);
        $tieneCaracterEspecial = preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);
    
        // Verificar que la contraseña cumple con todos los requisitos
        if (strlen($password) >= $longitudMinima && $tieneMayuscula && $tieneMinuscula && $tieneNumero && $tieneCaracterEspecial) {
            return true;
        } else {
            return false;
        }
    }
?>