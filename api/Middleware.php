<?php
require_once "api/utils/JWT.php"; // Asegúrate de que la ruta es correcta


function authenticate() {
   
    $headers = getallheaders();
    header('Content-Type: application/json');
    if (!isset($headers['Bearer']) ) {
       
        http_response_code(401);
        echo json_encode(['message' => 'Access denied', "error" => "Token no proporcionado"]);
        exit();
    }

    
    $token = str_replace("Bearer ", "", $headers['Bearer']);
    $decoded = JWTHandler::validateToken($token);

    if (!$decoded) {
        http_response_code(401);
        echo json_encode(["error" => "Token inválido o expirado"]);
        exit();
    }
    echo json_encode(['message' => 'Access granted', 'userData' => $decoded->data]);
    return $decoded->data; 
}
?>