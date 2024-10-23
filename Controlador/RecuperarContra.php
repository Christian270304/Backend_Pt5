<?php
    // Christian Torres Barrantes
    require_once 'Model/RecuperarContra.php';

    /**
     * Funcion para recuperar la contraseña mediante un token.
     * @email Parametro que nos indica el correo del usuario.
     */
    function recuperarPassword($email){
        $correo = isset($email) ? trim(htmlspecialchars($email)) : '';

        if (!empty($correo)) {
            // Verificar si el correo existe en la base de datos
            $usuario = obtenerUsuarioPorCorreo($correo);
            var_dump($usuario);
            if ($usuario) {
                // Generar un token único
                $token = bin2hex(random_bytes(50)); // Token de 100 caracteres

                // Guardar el token en la base de datos junto con el correo del usuario
                $expira = date("Y-m-d H:i:s", strtotime('+1 hour')); // El token expira en 1 hora
                var_dump(insertarToken($usuario['id'], $token, $expira));

                // Enviar un correo electrónico al usuario con el enlace de recuperación
                
                $enlaceRestablecer = "http://localhost/Practica-04/index.php?pagina=Restablecer&token=" . $token;
                $asunto = "Recuperación de contraseña";
                $mensaje = "Hola, para restablecer tu contraseña, haz clic en el siguiente enlace: " . $enlaceRestablecer;
                require 'enviar_correo.php';
                
                //enviarCorreo($correo, $asunto, $mensaje);

                echo "Se ha enviado un enlace de recuperación a tu correo electrónico.";
            } else {
                echo "El correo electrónico no está registrado.";
            }
        } else {
            echo "El campo del correo no puede estar vacio";
        }
        include 'Html/RecuperarContra.php';
        //header("Location: index.php?pagina=Login");
    }

    function enviarCorreo($para, $asunto, $mensaje) {
        $cabeceras = 'From: no-reply@tudominio.com' . "\r\n" .
                     'Reply-To: no-reply@tudominio.com' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();
    
        mail($para, $asunto, $mensaje, $cabeceras);
    }
?>