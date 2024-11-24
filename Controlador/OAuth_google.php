<?php

// Cargar la biblioteca de Google API
require 'libs/GoogleAPI/google-api-php-client-main/src/Client.php'; 
require 'GoogleAPI/src/contrib/Google_Oauth2Service.php';

$id_token = $_POST['id_token'];

// Crear un cliente de Google
$client = new Google_Client(['client_id' => 'TU_CLIENT_ID.apps.googleusercontent.com']);
$payload = $client->verifyIdToken($id_token);

if ($payload) {
    $userid = $payload['sub'];
    // Aquí puedes buscar al usuario en tu base de datos y crear una sesión
    // Si el usuario no existe, puedes crearlo
    echo 'Usuario autenticado: ' . $userid;
} else {
    // El token no es válido
    echo 'Invalid ID token';
}
?>
