<?php
require_once __DIR__ . '../Utils/JWT.php';

header('Content-Type: application/json');


$headers = getallheaders();
$authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

if (!$authHeader) {
    http_response_code(401);
    echo json_encode(['message' => 'Authorization header not found']);
    exit;
}

$refreshToken = str_replace('Bearer ', '', $authHeader);
$userData = JWTHandler::validateRefreshToken($refreshToken);

if (!$userData) {
    http_response_code(401);
    echo json_encode(['message' => 'Invalid or expired refresh token']);
    exit;
}

// Generar un nuevo access token
$accessToken = JWTHandler::generateToken(['username' => $userData->data->username, 'username' => $userData->data->username]);

echo json_encode(['message'=>'Token Generado','accessToken' => $accessToken]);

?>