<?php

// Cargar la biblioteca de Google API
require_once 'libs/Google_Auth/vendor/autoload.php';
require_once 'Model/OAuth_google.php';

require_once 'env.php';


// Crear un cliente de Google
$client = new Google_Client();
$client->setClientId(CLIENTE_ID); // Reemplaza con tu Client ID
$client->setClientSecret(CLIENTE_SECRET);
$client->setRedirectUri(REDIRECT_URI);


if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Obtener el perfil de Google
    $google_oauth = new Google_Service_Oauth2($client);
    $google_user_data = $google_oauth->userinfo->get();
    $email = $google_user_data->email;
    $name = $google_user_data->name;

    
    $result = buscarUsuarioPorEmail($email); // Implementa esta función para buscar por email

    if ($result) {
        // Usuario existe, iniciar sesión
        $_SESSION['username'] = $result['username'];
        $_SESSION['profile_image'] = $result['ruta_imagen']; // O la imagen predeterminada
        header("Location: index.php?pagina=Mostrar");
    } else {
        // Usuario no existe, puedes crear uno nuevo
        if (crearUsuarioDesdeGoogle($email,$name)){
            $_SESSION['username'] = $name;
            header("Location: index.php?pagina=Mostrar");
        }
    }
}


?>
