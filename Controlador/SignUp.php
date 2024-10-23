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
            $mensajes[] = "El campo del Username no puede estar vacio";
        }
    
        if (empty($correo)) {
            $mensajes[] = "El campo del correo no puede estar vacio";
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $mensajes[] = 'El campo de email no es valido';
        }
    
        if (empty($contra1)) {
            $mensajes[] = "El campo de la contraseña no puede estar vacio";
        } else if (empty($contra2)) {
            $mensajes[] = "Por favor repita la contraseña.";
        }
    
        // Verificar si el usuario o correo ya existen
        $result = usrExist($username, $correo);
        if ($result > 0) {
            $mensajes[] = "El nombre de usuario o el email ya están registrados.";
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
                        $mensajes[] = "Error al registrar el usuario.";
                    }
                } else {
                    // Mensaje si la contraseña no es fuerte
                    $mensajes[] = "La contraseña debe contener:<br/> - Un minimo de 8 caracteres. <br/> - Una letra mayúscula. <br/> - Una letra minúscula. <br/> - Un número. <br/> - Y un carácter especial.";
                }
            } else {
                $mensajes[] = "Las contraseñas no coinciden.";
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