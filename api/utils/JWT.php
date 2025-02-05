<?php
require_once __DIR__ . '/../../libs/vendor/autoload.php';
require_once __DIR__ . '/../../env.php';
require_once __DIR__ . '/../../Model/RecuperarContra.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHandler {
    private static $secret_key = API_KEY; 
    private static $algorithm = ALGORITMO;
    private static $refresh_secret_key = REFRESH_API_KEY; 

    // Función para generar un token JWT
    public static function generateToken($data) {
        $payload = [
            "iat" => time(), 
            "exp" => time() + (60), 
            "data" => $data
        ];
        return JWT::encode($payload, self::$secret_key, self::$algorithm);
    }

    // Función para generar un refresh token
    public static function generateRefreshToken($data) {
        $payload = [
            "iat" => time(), 
            "exp" => time() + (60 * 60 * 24 * 7), // Expira en 1 semana
            "data" => $data
        ];
        return JWT::encode($payload, self::$refresh_secret_key, self::$algorithm);
    }

    // Función para validar un token JWT
    public static function validateToken($token) {
        try {
            return JWT::decode($token, new Key(self::$secret_key, self::$algorithm));
        } catch (Exception $e) {
            return false; 
        }
    }

    // Función para validar un refresh token
    public static function validateRefreshToken($token) {
        try {
            return JWT::decode($token, new Key(self::$refresh_secret_key, self::$algorithm));
        } catch (Exception $e) {
            return false; 
        }
    }

    public static function crearTokens() {
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $token = JWTHandler::generateToken(['username' => $username]);
            if (obtenerTokenRefresh($username)){
                $refreshToken = obtenerTokenRefresh($username);
                
            } else {
                $refreshToken = JWTHandler::generateRefreshToken(['username' => $username]);
                $id = obtenerUsuarioPorUsername($username);
                insertarToken($id['id'], $refreshToken, (time() + (60 * 60 * 24 * 30)), 'refreshtoken');
            }
           
            echo json_encode(['token' => $token, 'refreshToken' => $refreshToken]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Usuario no autenticado']);
        }
        exit;
    }
}

?>