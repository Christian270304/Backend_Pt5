<?php
// Christian Torres Barrantes
require_once 'Model/RecuperarContra.php';

/**
 * Funcion para recuperar la contraseña mediante un token.
 * @email Parametro que nos indica el correo del usuario.
 */
function recuperarPassword($email)
{
    $correo = isset($email) ? trim(htmlspecialchars($email)) : '';

    $error_message = '';
    $success_message = '';

    if (!empty($correo)) {
        // Verificar si el correo existe en la base de datos
        $usuario = obtenerUsuarioPorCorreo($correo);

        if ($usuario) {

            if (!verificarCuentaSocial($usuario['id'])) {
                // Generar un token único
            $token = bin2hex(random_bytes(50)); // Token de 100 caracteres

            // Guardar el token en la base de datos junto con el correo del usuario
            $expira = date("Y-m-d H:i:s", strtotime('+1 hour')); // El token expira en 1 hora
            insertarToken($usuario['id'], $token, $expira);

            // Enviar un correo electrónico al usuario con el enlace de recuperación

            $asunto = "Recuperación de contraseña";
            $mensaje = "
                        <html>
                        <head>
                            <title>Recuperación de Contraseña</title>
                        </head>
                        <body style='font-family: Arial, sans-serif; background-color: #f6f6f6; margin: 0; padding: 20px;'>
                            <div style='max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>
                                <h2 style='color: #333;'>Hola!</h2>
                                <p style='color: #555;'>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta.</p>
                                <p style='color: #555;'>Para restablecer tu contraseña, haz clic en el botón de abajo:</p>
                                
                                <a href='http://localhost/Backend-Pt05/index.php?pagina=Restablecer&token=$token' style='display: inline-block; background-color: #007BFF; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 10px;'>Restablecer Contraseña</a>

                                <p style='color: #555; margin-top: 20px;'>Si no solicitaste un restablecimiento de contraseña, simplemente puedes ignorar este correo.</p>
                                
                                <p style='color: #555;'>Gracias,<br>El equipo de soporte</p>
                            </div>
                        </body>
                        </html>
                        ";
            require 'enviar_correo.php';

            $success_message = "S'ha enviat un enllaç de recuperació al teu correu electrònic";
            } else {
                $error_message = "Aquest correu està associat a una compte Socil. No es pot restablir la contrasenya";
                
            }
        } else {
            $error_message = "El correu electrònic no està registrat";
        }
    } else {
        $error_message = "El camp del correu no pot estar buit";
    }
    include 'Html/RecuperarContra.php';
    
}

function GuardarRefreshToken($token){
    $usuario = obtenerUsuarioPorCorreo($_SESSION['username']);
    if ($usuario) {
        $expira = date("Y-m-d H:i:s", strtotime('+30 days'));
        insertarToken($usuario['id'], $token, $expira);
    } 
}


function mostrarMensaje($mensaje, $tipo = 'success')
{
    if (!empty($mensaje)) {
        $class = $tipo === 'error' ? 'error-message' : 'success-message';
        return '<div class="' . $class . '">' . htmlspecialchars($mensaje) . '</div>';
    }
    return '';
}
