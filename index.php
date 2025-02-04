<?php
    // Christian Torres Barrantes


    require_once 'env.php';

    ini_set('session.gc_probability', 1);
    ini_set('session.gc_divisor', 100);
    ini_set('session.use_cookies', 1);
    
    

    session_start();
    $tiempo_max_inactividad = 2400; 

    // Comprobar si el usuario está logueado
    if (isset($_SESSION['username'])) {
        // Verificar si la sesión tiene un registro de la última actividad
        if (isset($_SESSION['last_activity'])) {
            // Calcular el tiempo de inactividad
            $tiempo_inactivo = time() - $_SESSION['last_activity'];

            // Si ha pasado el tiempo máximo de inactividad, destruir la sesión y redirigir
            if ($tiempo_inactivo > $tiempo_max_inactividad) {
                session_unset();   // Destruir todas las variables de sesión
                session_destroy(); // Destruir la sesión

                // Redirigir al login con mensaje de sesión expirada
                header("Location: index.php?pagina=MostrarInici&expired=1");
                exit();
            }
        } 

        // Actualizar la última actividad del usuario
        $_SESSION['last_activity'] = time();
    } else {
        // Verificar si hay un token de sesión
        if (isset($_COOKIE['session_token'])) {
            $token = $_COOKIE['session_token'];
            require_once 'Model/RestablecerContra.php';
            // Obtener usuario por token
            $usuario = obtenerUsuarioPorToken($token);
            if ($usuario) {
                // Iniciar sesión automáticamente
                $_SESSION['username'] = $usuario['username'];
                $_SESSION['profile_image'] = $usuario['ruta_imagen']; // O la imagen predeterminada
                $_SESSION['login_attempts'] = 0; // Reiniciar intentos de inicio de sesión
                header("Location: index.php?pagina=Mostrar");
                exit();
            } else {
                // Token no válido, puedes eliminar la cookie
                setcookie('session_token', '', time() - 3600, "/"); // Eliminar cookie
                cerrarSesion();
            }
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        // API
        if (strpos($_SERVER['REQUEST_URI'], '/Backend_Pt5/api/') !== false) {
            require_once 'api/routes/apiRoutes.php';
        }

        $opcion = isset($_GET['pagina']) ? $_GET['pagina'] : 'MostrarInici';
        switch ($opcion) {
            case 'Inicio':
                if (!isset($_SESSION['username'])){
                    header("Location: index.php?pagina=MostrarInici&expired=1");
                } else {
                    require_once 'Controlador/MostrarInici.php';
                    include 'Html/Inicio.php';
                }
                break;
            case 'Mostrar':
                if (!(isset($_SESSION['username'])) && !(isset($_SESSION['social-auth']))){
                    header("Location: index.php?pagina=MostrarInici");
                } else {
                    require_once 'Controlador/Mostrar.php';
                    include 'Html/Mostrar.php';
                }
                break;
            case 'Insertar':
                if (!isset($_SESSION['username'])){
                    header("Location: index.php?pagina=MostrarInici&expired=1");
                } else {
                    require_once 'Controlador/Insertar.php';
                include 'Html/Insertar.php';
                }
                break;
            case 'Borrar':
                if (!isset($_SESSION['username'])){
                    header("Location: index.php?pagina=MostrarInici&expired=1");
                } else {
                    require_once 'Controlador/Borrar.php';
                    include 'Html/Borrar.php';
                }
                break;
            case 'Modificar':
                if (!isset($_SESSION['username'])){
                    header("Location: index.php?pagina=MostrarInici&expired=1");
                } else {
                    require_once 'Controlador/Modificar.php';
                    include 'Html/Modificar.php';
                }
                break;
            case 'MostrarInici':
                require_once 'Controlador/Login.php';

                if (isset($_SESSION['username']) && isset($_COOKIE['session_token'])) {
                    
                    $user = validarTokenRememberMe($_COOKIE['session_token']); // Ensure this function is defined

                    if ($user) {
                        
                        $_SESSION['username'] = $user['username'];
                        header("Location: index.php?pagina=Mostrar");
                    }
                }
              
                if (isset($_SESSION['username']) || isset($_GET['logout'])) {
                    setcookie('session_token', '', time() - 3600, "/"); 
                    session_unset();
                    session_destroy();
                }
                
                require_once 'Controlador/MostrarInici.php';
                include 'Html/MostrarInici.php';
                break;
            case 'Login':
                require_once 'Controlador/Login.php';
                include 'Html/Login.php';
                break;
            case 'SubirImagen':
                if (isset($_SESSION['username'])){
                    require_once 'Controlador/Perfil.php';
                    include 'Html/Perfil.php';
                } else {
                    header("Location: index.php?pagina=MostrarInici");
                    exit;
                }
                break;
            case 'RecuperarContra':
                require_once 'Controlador/RecuperarContra.php';
                include 'Html/RecuperarContra.php';
                break;
            case 'Perfil':
                if (isset($_SESSION['username'])){
                    require_once 'Controlador/Perfil.php';
                    include 'Html/Perfil.php';
                } else {
                    header("Location: index.php?pagina=MostrarInici");
                    exit;
                }
                break;
            case 'UserProfile':
                    require_once 'Controlador/UserProfile.php';
                    include 'Html/UserProfile.php';
                break;
            case 'LeerQR':
                //require_once 'Controlador/UserProfile.php';
                include 'Html/LeerQR.php';
                break;
            case 'SignUp':
                require_once 'Controlador/SignUp.php';
                include 'Html/SignUp.php';
                break;
            case 'Restablecer':
                if (isset($_GET['token']) ? $_GET['token']: "") {
                    require_once 'Controlador/RestablecerContra.php';
                    include 'Html/RestablecerContra.php';
                    
                } else {
                    header("Location: index.php?pagina=MostrarInici");
                    exit;
                }
                
                break;
            case 'BorrarVerificar':
                require_once 'Controlador/Borrar.php';
                verificarDelet($_GET['id']);
                break;
            case 'ModificarArticulo':
                require_once 'Controlador/Modificar.php';
                modificarPagina($_GET['id']);
                break;
            case 'hybridauth':
                require_once 'Controlador/authenticate.php';
                break;
            case 'OAuth':
                require_once 'Controlador/OAuth_google.php';
                break;
            case 'Admin':
                if (isset($_SESSION['username']) && $_SESSION['username'] == 'admin'){
                    include 'Html/AdminUsuarios.php';
                } else {
                    if (isset($_SESSION['username'])) {
                        header("Location: index.php?pagina=Mostrar");
                        exit;
                    } else {
                        header("Location: index.php?pagina=MostrarInici");
                        exit;
                    }
                }
                break;
            default:
            if (isset($_SESSION['username'])){
                header("Location: index.php?pagina=Mostrar");
                exit;
            } else {
                header("Location: index.php?pagina=MostrarInici");
            }
               
        }
        
    } else if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (strpos($_SERVER['REQUEST_URI'], '/Backend_Pt5/api/utils/JWT.php') !== false) {
            require_once 'api/utils/JWT.php';
            exit;
        }
        if (strpos($_SERVER['REQUEST_URI'], '/Backend_Pt5/api/refreshtoken') !== false) {
            require_once 'api/RefreshToken.php';
            exit;
        }
        $opcion = isset($_GET['pagina']) ? $_GET['pagina'] : 'Mostrar';
        switch ($opcion) {
            case 'Insertar':
                require_once 'Controlador/Insertar.php';
                insertarDatos($_POST['titulo'],$_POST['cuerpo']);
                break;
            case 'Borrar':
                include 'Html/Borrar.php';
                break;
            case 'BorrarVerificar':
                if ($_POST['boton'] === 'Si') {
                    // Acción cuando se presiona el botón "Sí"
                    require_once 'Controlador/Borrar.php';
                    borrar($_POST['titulo'],$_POST['cuerpo']);
                } elseif ($_POST['boton'] === 'No') {
                    // Acción cuando se presiona el botón "No"
                    require_once 'Controlador/Borrar.php';
                    header("Location: index.php?pagina=Borrar");
                }
                break;
            case 'Login':
                require_once 'Controlador/Login.php';
                loginDatos($_POST['username'],$_POST['contra'],isset($_POST['g-recaptcha-response'])?$_POST['g-recaptcha-response']: "",isset($_POST['remember_me']) ? $_POST['remember_me'] : "", isset($_POST['qr']) ? $_POST['qr'] : "");
                break;
            case 'SignUp':
                require_once 'Controlador/SignUp.php';
                verificarDatos($_POST['username'],$_POST['correo'],$_POST['contra1'],$_POST['contra2'],$_POST['id_token']);
                break;
            case 'Modificar':
                require_once 'Controlador/Modificar.php';
                modificar($_POST['boton'],$_POST['titulo'],$_POST['cuerpo']);
                break;
            case 'Recuperar':
                require_once 'Controlador/RecuperarContra.php';
                recuperarPassword($_POST['correo']);
                break;
            case 'Restablecer':
                require_once 'Controlador/RestablecerContra.php';
                restablecerPassword($_POST['token'],$_POST['password1'],$_POST['password2']);
                break;
            case 'SubirImagen':
                require_once 'Controlador/Perfil.php';
                require_once 'Controlador/SubirImagen.php';
                include 'Html/Perfil.php';
                break;
            case 'CambiarContra':
                require_once 'Controlador/Perfil.php';
                verificarPassword($_POST['old_password'],$_POST['new_password'],$_POST['confirm_password']);
                break;
            case 'ChangeEmail':
                require_once 'Controlador/Perfil.php';
                changeEmail($_POST['email']);
                break;
            case 'ChangeBio':
                require_once 'Controlador/Perfil.php';
                changeBio($_POST['bio']);
                break;
            case 'ChangeUsername':
                require_once 'Controlador/Perfil.php';
                changeUsername($_POST['username']);
                break;
            case 'EliminarUsuario':
                require_once 'Controlador/EliminarUsuario.php';
                eliminarCuenta($_POST['user_id'],isset($_POST['eliminarArticulos'])? $_POST['eliminarArticulos']: false);
                break;
            case 'LeerQR':
                require_once 'leerQR.php';
                break;
            default:
            if (isset($_SESSION['username'])){
                header("Location: index.php?pagina=Mostrar");
                exit;
            } else {
                header("Location: index.php?pagina=MostrarInici");
            }
        }
    } 
    
    
?>