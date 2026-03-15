<?php
namespace App\Services;

use Exception;

class JWTServices {
    private $secret;
    private $algorithm = 'HS256';
    private $issuer = 'naps.gov.tz';
    private $audience = 'naps-users';
    public function __construct($secret = null) {
       
        $this->secret = $secret ?? getenv('JWT_SECRET') ?: 'naps_secure_default_key_2026_@_change_me';
    }
    private function base64UrlEncode($data) {
        return rtrim(str_replace(['+', '/'], ['-', '_'], base64_encode($data)), '=');
    }
private function base64UrlDecode($data) {
    $remainder = strlen($data) % 4;
    if ($remainder) {
        $padlen = 4 - $remainder;
        $data .= str_repeat('=', $padlen);
    }
    $data = strtr($data, '-_', '+/');
    
   
    $decoded = base64_decode($data, true);
    
    if ($decoded === false) {
        error_log("DEBUG: Base64 decode failed for data: " . $data);
        return "";
    }
    return $decoded;
}
 
    public function generateToken($payload, $expiry = 3600) {
        try {
            if (empty($payload) || !is_array($payload)) {
                throw new Exception("Payload must be a non-empty array");
            }

            $header = [
                'alg' => $this->algorithm,
                'typ' => 'JWT'
            ];

            $now = time();
            $payload = array_merge($payload, [
                'iss' => $this->issuer,
                'aud' => $this->audience,
                'iat' => $now,
                'exp' => $now + $expiry
            ]);

            $encodedHeader = $this->base64UrlEncode(json_encode($header));
            $encodedPayload = $this->base64UrlEncode(json_encode($payload));

            $message = "$encodedHeader.$encodedPayload";
            $signature = hash_hmac('sha256', $message, $this->secret, true);
            $encodedSignature = $this->base64UrlEncode($signature);

            return "$message.$encodedSignature";

        } catch (Exception $e) {
            error_log("Error generating JWT: " . $e->getMessage());
            return false;
        }
    }
    public function verifyToken($token) {
        try {
            if (empty($token) || !is_string($token)) {
                throw new Exception("Invalid token format");
            }

            $parts = explode('.', $token);
            if (count($parts) !== 3) {
                throw new Exception("Token must have exactly 3 parts");
            }

            list($encodedHeader, $encodedPayload, $encodedSignature) = $parts;
            $message = "$encodedHeader.$encodedPayload";
            $expectedSignature = hash_hmac('sha256', $message, $this->secret, true);
            $providedSignature = $this->base64UrlDecode($encodedSignature);

            if (!hash_equals($expectedSignature, $providedSignature)) {
                throw new Exception("Invalid signature");
            }

            $payload = json_decode($this->base64UrlDecode($encodedPayload), true);

            if (!$payload) {
                throw new Exception("Invalid payload JSON");
            }
            if (isset($payload['exp']) && $payload['exp'] < time()) {
                throw new Exception("Token has expired");
            }
            if (isset($payload['iss']) && $payload['iss'] !== $this->issuer) {
                throw new Exception("Invalid issuer");
            }

            return $payload;

        } catch (Exception $e) {
            error_log("Token verification failed: " . $e->getMessage());
            return false;
        }
    }
    public function refreshToken($token, $expiry = 3600) {
        $payload = $this->verifyToken($token);
        if ($payload === false) return false;

        unset($payload['exp'], $payload['iat'], $payload['iss'], $payload['aud']);
        return $this->generateToken($payload, $expiry);
    }

    public static function extractTokenFromHeader() {
        $authHeader = null;
        if (isset($_SERVER['Authorization'])) {
            $authHeader = $_SERVER['Authorization'];
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        } elseif (function_exists('getallheaders')) {
            $headers = getallheaders();
            $authHeader = $headers['Authorization'] ?? null;
        }

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return $matches[1];
        }

        return null;
    }
    public function generateUserToken($userId, $username, $email, $role, $expiry = 86400) {
        return $this->generateToken([
            'id' => $userId,
            'username' => $username,
            'email' => $email,
            'role' => $role
        ], $expiry);
    }

    public function decodeToken($token) {
        $parts = explode('.', $token);
        if (count($parts) !== 3) return false;
        return json_decode($this->base64UrlDecode($parts[1]), true);
    }

    public function isTokenExpired($token) {
        $payload = $this->decodeToken($token);
        return ($payload === false || !isset($payload['exp'])) ? true : ($payload['exp'] < time());
    }
}