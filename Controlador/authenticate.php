<?php
require_once __DIR__ . '\..\libs\vendor\autoload.php';
require_once __DIR__ . '\..\Model\Social_Auth.php';
require_once __DIR__ . '\..\conexion.php';
use Hybridauth\Hybridauth;
use Hybridauth\Hybridauth\SRC\HttpClient;

$config = require __DIR__ . '\..\hybridauth.php';

try {
    $hybridauth = new Hybridauth($config);
    $adapter = $hybridauth->authenticate('GitHub');
    $userProfile = $adapter->getUserProfile();
    $code = isset($_GET['code'])? $_GET['code']: '';
    

    $name = $userProfile->identifier;
    $email = $userProfile->email;

    $result = buscarUsuarioPorEmail($email); // Implementa esta función para buscar por email

    if ($result) {
        // Usuario existe, iniciar sesión
        $_SESSION['username'] = $name;
    
      
        header("Location: index.php?pagina=Mostrar");
    } else {
        // Usuario no existe, puedes crear uno nuevo
        if (crearUsuarioDesdeGitHub($email,$name)){

            $_SESSION['username'] = $name;
            header("Location: index.php?pagina=Mostrar");
        }
     
    }
    
} catch (\Exception $e) {
    echo 'Oops, we ran into an issue! ' . $e->getMessage();
}
?>