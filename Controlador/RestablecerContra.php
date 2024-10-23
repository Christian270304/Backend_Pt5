<?php
    // Christian Torres Barrantes
    require_once 'Model/RestablecerContra.php';

    function restablecerPassword($toke,$password1,$password2) {
        $token = isset($toke) ? trim($toke) : '';
        var_dump($token);
        $contra1 = isset($password1) ? trim($password1) : '';
        $contra2 = isset($password2) ? trim($password2) : '';

        if (!empty($token) && !empty($contra1) && $contra1 === $contra2) {
            // Verificar si el token es válido y no ha expirado
            $usuario = obtenerUsuarioPorToken($token);

            if ($usuario) {
                // Validar fortaleza de la contraseña (puedes reutilizar la función de antes)
                if (validarContraseña($contra1)) {
                    // Encriptar la nueva contraseña
                    $hashed_password = password_hash($contra1, PASSWORD_DEFAULT);

                    // Actualizar la contraseña del usuario en la base de datos
                    actualizarContrasena($usuario['user_id'], $hashed_password);

                    // Borrar el token de la base de datos
                    borrarToken($token);

                    echo "Contraseña actualizada con éxito. Ahora puedes iniciar sesión.";
                    header("Location: index.php?pagina=Login");
                } else {
                    echo "La contraseña no es lo suficientemente fuerte.";
                }
            } else {
                echo "El token es inválido o ha expirado.";
            }
        } else {
            echo "Las contraseñas no coinciden.";
        }
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