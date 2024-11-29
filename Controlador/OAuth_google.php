<?php

// Cargar la biblioteca de Google API
require 'libs/GoogleAPI/google-api-php-client-main/src/Client.php';

require_once 'env.php';
$id_token = $_POST['id_token'];

// Crear un cliente de Google
$client = new Google\Client();
$client->setClientId(CLIENTE_ID); // Reemplaza con tu Client ID
$client->setClientSecret(CLIENTE_SECRET); // Reemplaza con tu Client Secret
// Verificar el token
$payload = $client->verifyIdToken($id_token);
if ($payload) {
    $userid = $payload['sub']; // ID del usuario
    $email = $payload['email']; // Email del usuario

    // Aquí puedes buscar al usuario en tu base de datos
    // Si el usuario no existe, puedes crearlo
    // Por ejemplo:
    $result = buscarUsuarioPorEmail($email); // Implementa esta función para buscar por email

    if ($result) {
        // Usuario existe, iniciar sesión
        $_SESSION['username'] = $result['username'];
        $_SESSION['profile_image'] = $result['ruta_imagen']; // O la imagen predeterminada
        header("Location: index.php?pagina=Mostrar");
    } else {
        // Usuario no existe, puedes crear uno nuevo
        crearUsuarioDesdeGoogle($payload); // Implementa esta función para crear un nuevo usuario
        header("Location: index.php?pagina=Mostrar");
    }
} else {
    // El token no es válido
    echo 'Invalid ID token';
}
require_once 'conexion.php';

function buscarUsuarioPorEmail($email) {
    global $conn;
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->execute([':email' => $email]);
    return $stmt->fetch (PDO::FETCH_ASSOC);
}

function crearUsuarioDesdeGoogle($payload) {
    global $conn;
    $query = "INSERT INTO users (username, email, password, ruta_imagen, creado_el) VALUES (:username, :email, :password, :ruta_imagen, NOW())";
    $stmt = $conn->prepare($query);
    $username = $payload['name']; // O cualquier otro campo que desees usar
    $email = $payload['email'];
    $password = password_hash(uniqid(), PASSWORD_DEFAULT); // Generar una contraseña aleatoria
    $ruta_imagen = $payload['picture']; // URL de la imagen de perfil

    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $password,
        ':ruta_imagen' => $ruta_imagen
    ]);
}
?>
