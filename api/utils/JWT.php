<?php
require_once __DIR__ . '/../../libs/vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHandler {
    private static $secret_key = "tu_clave_secreta"; // 🔒 Cambia esto por una clave segura
    private static $algorithm = "HS256";

    // Función para generar un token JWT
    public static function generateToken($data) {
        $payload = [
            "iat" => time(), // Fecha de creación
            "exp" => time() + (60 * 60), // Expira en 1 hora
            "data" => $data
        ];
        return JWT::encode($payload, self::$secret_key, self::$algorithm);
    }

    // Función para validar un token JWT
    public static function validateToken($token) {
        try {
            return JWT::decode($token, new Key(self::$secret_key, self::$algorithm));
        } catch (Exception $e) {
            return false; // Si el token no es válido, retorna falso
        }
    }
}
?>