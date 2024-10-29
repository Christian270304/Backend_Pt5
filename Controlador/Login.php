<?php
    // Christian Torres Barrantes
    require_once 'Model/Login.php';

    /**
     * Funcion que verifica los datos cuando el usuario se intena loguear.
     * @user Parametro que nos indica el username del usuario.
     * @password Parametro que nos indica la contraseña del usuario.
     */
    function loginDatos($user, $password) {
        $defaultImage = "https://storage.googleapis.com/a1aa/image/JLwi3piUzQY3G92u0CH63SjxE3kuf8lWqsoTZH7fYWfAkqWnA.jpg";
        $mensajes = array();
        $mensaje = '';

        // Validar inputs
        $username = isset($user) ? trim(htmlspecialchars($user)) : '';
        $contra = isset($password) ? trim(htmlspecialchars($password)) : '';

        if (empty($username)) {
            $mensajes[] = "El campo del correo no puede estar vacío";
        }

        if (empty($contra)) {
            $mensajes[] = "El campo de la contraseña no puede estar vacío";
        }

        // Solo continuamos si no hay errores previos
        if (empty($mensajes)) {
            // Buscar usuario en la base de datos
            $result = buscarUsuario($username);
            if ($result) {
                // Verificar la contraseña con el hash
                if (password_verify($contra, $result['password'])) {
                    // Iniciar la sesión
                    $_SESSION['username'] = $result['username']? $result['username']: $defaultImage;
                    // Guardar la ruta de la imagen del usuario.
                    $_SESSION['profile_image'] = $result['ruta_imagen'];
                    header("Location: index.php?pagina=Mostrar");
                    exit;  // Detener ejecución después de redirigir
                } else {
                    $mensajes[] = "Contraseña incorrecta";
                }
            } else {
                $mensajes[] = "Usuario no encontrado";
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