<?php
    // Christian Torres Barrantes

    require_once 'Model/Perfil.php';

    function mostrarEmail() {
        $user_id = idUsuario($_SESSION['username']);
        $email = email($user_id);
        
        return $email;
    }

    function verificarPassword($passAntigui, $passNuevo, $passNuevo2) {
        $mensajes = [];
        $errores = '';

        // Validar inputs
        $contraAntigua = isset($passAntigui) ? trim(htmlspecialchars($passAntigui)) : '';
        $contraNueva = isset($passNuevo) ? trim(htmlspecialchars($passNuevo)) : '';
        $contraNueva2 = isset($passNuevo2) ? trim(htmlspecialchars($passNuevo2)) : '';

        if (empty($contraAntigua)) {
            $mensajes[] = "Tiene que introducir su contraseña actual";
        }

        if (empty($passNuevo)) {
            $mensajes[] = "El campo de la nueva contraseña no puede estar vacio";
        }else if (empty($passNuevo2)){
            $mensajes[] = "Por favor repita la contraseña";
        }

        // Solo continuamos si no hay errores previos
        if (empty($mensajes)) {
            $result = buscarUsuario($_SESSION['username']);
            if ($result) {
                $passwVerificado = validarContrasena($contraNueva);
                if ($passwVerificado){
                    if (password_verify($contraAntigua, $result['password'])) {
                        $hashed_password = password_hash($passNuevo, PASSWORD_DEFAULT);
                        $changed = cambiarPassword($result['id'],$hashed_password);
                        if ($changed){
                            $mensajes[] = "La contrasenya s'ha modificat.";
                            //header("Location: index.php?pagina=Perfil");
                            //exit;  
                        } else {
                            $mensajes[] = "No s'ha pogut cambiar la contrasenya";
                        }
                    } else {
                        $mensajes[] = "Contrasenya incorrecta";
                    }
                } else {
                    $mensajes[] = "La contrasenya ha de contenir:<br/> - Un mínim de 8 caràcters. <br/> - Una lletra majúscula. <br/> - Una lletra minúscula. <br/> - Un nombre. <br/> - I un caràcter especial.";
                }
            } else {
                $mensajes[] = "Usuario no trobat";
            }
        }

        // Generar mensajes de error
        if (!empty($mensajes)) {
            $errores .= '<div id="caja_mensaje" class="errors">';
            foreach ($mensajes as $mensaje) {
                $errores .= $mensaje . '<br/>';
            }
            $errores .= '</div>';
        }

        include 'Html/Perfil.php';
    }

    function validarContrasena($password) {
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