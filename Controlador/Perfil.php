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
            // Buscar usuario en la base de datos
            $result = buscarUsuario($_SESSION['username']);
            if ($result) {
                // Verificar la contraseña con el hash
                if (password_verify($contraAntigua, $result['password'])) {
                    $hashed_password = password_hash($passNuevo, PASSWORD_DEFAULT);
                    $changed = cambiarPassword($result['id'],$hashed_password);
                    if ($changed){
                        header("Location: index.php?pagina=Perfil");
                        exit;  // Detener ejecución después de redirigir
                    } else {
                        $mensajes[] = "No se ha podido cambiar la contraseña";
                    }
                } else {
                    $mensajes[] = "Contraseña incorrecta";
                }
            } else {
                $mensajes[] = "Usuario no encontrado";
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
?>