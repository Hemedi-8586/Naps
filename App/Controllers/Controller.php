<?php
namespace App\Controllers;

use App\Services\JWTServices;
use App\Models\Model;

class Controller {
    protected $config;
    protected $jwt;

    public function __construct() {
        $this->config = require __DIR__ . '/../../env.php';
        $this->jwt = new JWTServices($this->config['jwt_secret']);
    }
    public function checkAuth() {
        $token = $_COOKIE['auth_token'] ?? JWTServices::extractTokenFromHeader();
        
        if (!$token) return null;

        $payload = $this->jwt->verifyToken($token);
        return $payload ?: null;
    }
    protected function authorize($requiredRole) {
        $user = $this->checkAuth();
        if (!$user || $user['role_name'] !== $requiredRole) {
            if ($this->isAjax()) {
                $this->json(['status' => 'error', 'message' => 'Forbidden: Access Denied'], 403);
            }
            $this->redirect('/login?error=Access Denied');
        }
        return $user;
    }
    public function view($view, $data = []) {
        $payload = $this->checkAuth();
        if (!$payload) {
            $this->redirect('/login');
        }
        $model = new Model();
        $userSettings = $model->where('users', ['id' => $payload['id']])[0] ?? null;
        $lang = $userSettings['language_preference'] ?? 'sw';
        $data['user_settings'] = [
            'theme_preference'    => $userSettings['theme_preference'] ?? 'light',
            'language_preference' => $userSettings['language_preference'] ?? 'sw'
        ];
        $langFile = APP_ROOT . "/App/Languages/{$lang}.php";
        $data['lang'] = file_exists($langFile) ? require $langFile : require APP_ROOT . "/App/Languages/sw.php";
    
      $data['user_settings'] = [
        'theme_preference'    => $userSettings['theme_preference'] ?? 'light',
        'language_preference' => $lang
    ];
        $data['auth_user'] = $payload; 
        $data['viewFile'] = basename($view, '.php'); 

        extract($data);
        $layoutFile = APP_ROOT . "/Resources/Views/dashboard/index.php";

        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            die("Layout missing at: $layoutFile");
        }
    }
    public function publicView($view, $data = []) {
        extract($data);
        $viewFile = APP_ROOT . "/Resources/Views/$view.php";
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            die("Public View not found: $view");
        }
    }
    public function json($data, $status = 200) {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }
    protected function getJsonInput() {
        $json = file_get_contents('php://input');
        return json_decode($json, true) ?? [];
    }
    public function redirect($url) {
        header("Location: /naps/" . ltrim($url, '/'));
        exit;
    }
    public function input($key) {
        $val = $_POST[$key] ?? $_GET[$key] ?? null;
        return $val ? htmlspecialchars(trim($val)) : null;
    }
    protected function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
}