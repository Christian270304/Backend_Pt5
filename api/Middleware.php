<?php
require_once "api/utils/JWT.php"; // Asegúrate de que la ruta es correcta

header('Content-Type: application/json');

function authenticate() {
   
    $headers = getallheaders();
    $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';
    
    if (!$authHeader) {
        http_response_code(401);
        echo json_encode(['message' => 'Access denied', "error" => "Token no proporcionado"]);
        exit;
    }
    

    
    $token = str_replace('Bearer ', '', $authHeader);
    $decoded = JWTHandler::validateToken($token);

    if (!$decoded) {
        http_response_code(401);
        echo json_encode(["error" => "Token inválido o expirado"]);
        exit();
    }
    echo json_encode(['message' => 'Access granted', 'userData' => $decoded->data]);
}
?>