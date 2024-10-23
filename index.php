<?php
    // Christian Torres Barrantes

    ini_set('session.gc_probability', 1);
    ini_set('session.gc_divisor', 100);

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
    }

   
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $opcion = isset($_GET['pagina']) ? $_GET['pagina'] : 'MostrarInici';
        switch ($opcion) {
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
            case 'Mostrar':
                if (!isset($_SESSION['username'])){
                    header("Location: index.php?pagina=MostrarInici&expired=1");
                } else {
                    require_once 'Controlador/Mostrar.php';
                    include 'Html/Mostrar.php';
                }
                break;
            case 'MostrarInici':
                if (isset($_SESSION['username'])){
                    session_destroy();
                    require_once 'Controlador/MostrarInici.php';
                    include 'Html/MostrarInici.php';
                } else {
                    require_once 'Controlador/MostrarInici.php';
                    include 'Html/MostrarInici.php';
                }
                break;
            case 'Login':
                require_once 'Controlador/Login.php';
                include 'Html/Login.php';
                break;
            case 'RecuperarContra':
                include 'Html/RecuperarContra.php';
                break;
            case 'Perfil':
                include 'Html/Perfil.php';
                break;
            case 'SignUp':
                include 'Html/SignUp.php';
                break;
            case 'Restablecer':
                require_once 'Controlador/RestablecerContra.php';
                include 'Html/RestablecerContra.php';
                break;
            case 'BorrarVerificar':
                require_once 'Controlador/Borrar.php';
                verificarDelet($_GET['id']);
                break;
            case 'ModificarArticulo':
                require_once 'Controlador/Modificar.php';
                modificarPagina($_GET['id']);
                break;
            default:
            if (isset($_SESSION['username'])){
                header("Location: index.php?pagina=Mostrar");
                exit;
            } else {
                header("Location: index.php?pagina=MostrarInici&expired=1");
            }
               
        }
    } else if($_SERVER['REQUEST_METHOD'] === 'POST'){
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
                loginDatos($_POST['username'],$_POST['contra']);
                break;
            case 'SignUp':
                require_once 'Controlador/SignUp.php';
                verificarDatos($_POST['username'],$_POST['correo'],$_POST['contra1'],$_POST['contra2']);
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
            default:
                include 'Html/Mostrar.php';
        }
    } 

    
    
    
?>