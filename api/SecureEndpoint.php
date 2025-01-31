<?php
require_once __DIR__ . '/../Utils/JWTUtils.php';
require_once __DIR__ . '/Middleware.php';

header('Content-Type: application/json');

// Verificar el token JWT
//$userData = verifyJWT();

// Aquí puedes continuar con la lógica de tu endpoint seguro
echo json_encode(['message' => 'Access granted', 'userData' => $userData]);
?>