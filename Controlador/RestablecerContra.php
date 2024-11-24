<?php
    // Christian Torres Barrantes
    require_once 'Model/RestablecerContra.php';

    function restablecerPassword($toke,$password1,$password2) {
        $token = isset($toke) ? trim($toke) : '';
        $contra1 = isset($password1) ? trim($password1) : '';
        $contra2 = isset($password2) ? trim($password2) : '';
        $error_message = '';
        $success_message = '';
        if (!empty($token) && !empty($contra1) && $contra1 === $contra2) {
            // Verificar si el token es válido y no ha expirado
            $usuario = obtenerUsuarioPorToken($token);

            if ($usuario) {
                // Validar fortaleza de la contraseña (puedes reutilizar la función de antes)
                if (validarContraseña($contra1)) {
                    if (!verificarContrasenaActual($usuario['username'], $contra1)) {
                        // Encriptar la nueva contraseña
                        $hashed_password = password_hash($contra1, PASSWORD_DEFAULT);
                        // Actualizar la contraseña del usuario
                        actualizarContrasena($usuario['id'], $hashed_password);
                        // Borrar el token después de usarlo
                        borrarToken($token);
                        $success_message .= "La contrasenya s'ha restablert correctament";
                    } else {
                        $error_message .= "La nova contrasenya no pot ser igual a l'actual";
                    }
                } else {
                    $error_message .= "La contrasenya no és prou forta";
                }
            } else {
                $error_message .= "El token és invàlid o ha expirat";
            }
        } else {
            $error_message .= "Les contrasenyes no coincideixen";
        }

        include 'Html/RestablecerContra.php';
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

    function mostrarMensaje($mensaje, $tipo = 'success') {
        if (!empty($mensaje)) {
            $class = $tipo === 'error' ? 'error-message' : 'success-message';
            return '<div class="' . $class . '">' . htmlspecialchars($mensaje) . '</div>';
        }
        return '';
    }
    
?>