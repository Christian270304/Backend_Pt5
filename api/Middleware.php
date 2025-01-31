<?php
require_once "api/utils/JWT.php"; // Asegúrate de que la ruta es correcta


function authenticate() {
    $headers = apache_request_headers();
    
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(["error" => "Token no proporcionado"]);
        exit();
    }

    $token = str_replace("Bearer ", "", $headers['Authorization']);
    $decoded = JWTHandler::validateToken($token);
    
    if (!$decoded) {
        http_response_code(401);
        echo json_encode(["error" => "Token inválido o expirado"]);
        exit();
    }

    return $decoded->data; // Retorna los datos del usuario si el token es válido
}
?>