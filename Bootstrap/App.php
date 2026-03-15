<?php
namespace Bootstrap;

use Exception;

class App {
    private $routes = [];

    public function __construct() {
        $this->loadRoutes();
    }
    private function loadRoutes() {
        $routeFile = APP_ROOT . '/Routes/web.php';
        if (!file_exists($routeFile)) {
            throw new Exception("Routes file not found: $routeFile");
        }
        $this->routes = require $routeFile;
    }
    private function getCurrentUrl() {
        $url = isset($_GET['url']) ? '/' . rtrim($_GET['url'], '/') : '/';
        $url = str_replace('//', '/', $url);
        return explode('?', $url)[0];
    }
    public function run() {
        try {
            $url = $this->getCurrentUrl();
            $method = $_SERVER['REQUEST_METHOD'];
            if (!isset($this->routes[$url])) {
                $this->handleNotFound($url);
                return;
            }

            $routeData = $this->routes[$url];
            $route = isset($routeData[$method]) ? $routeData[$method] : $routeData;

            $this->executeRoute($route);

        } catch (Exception $e) {
            $this->handleError($e);
        }
    }
    private function executeRoute($route) {
        $controllerName = $route['controller'];
        $action = $route['action'];

        $controllerClass = 'App\\Controllers\\' . $controllerName;
        
        if (!class_exists($controllerClass)) {
            throw new Exception("Controller $controllerClass not found");
        }

        $instance = new $controllerClass();
        
        if (!method_exists($instance, $action)) {
            throw new Exception("Action '$action' not found in $controllerName");
        }
        $instance->$action();
    }
    private function handleNotFound($url) {
        http_response_code(404);
        $view404 = APP_ROOT . '/Resources/Views/errors/404.php';
        if (file_exists($view404)) {
            include $view404;
        } else {
            echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>
                    <h1>404 - Ukurasa Haupatikani</h1>
                    <p>Hatukuweza kupata: <b>" . htmlspecialchars($url) . "</b></p>
                    <a href='/naps/'>Rudi Nyumbani</a>
                  </div>";
        }
        exit;
    }
    private function handleError(Exception $e) {
        error_log("NAPS Error: " . $e->getMessage());
        http_response_code(500);
        
        if (APP_DEBUG) {
            echo "<div style='background:#fff5f5; padding:20px; border:1px solid #ffcccc; font-family:sans-serif;'>
                    <h1 style='color:#d32f2f;'>500 - Server Error</h1>
                    <pre style='background:#eee; padding:10px; overflow-x:auto;'>" . htmlspecialchars($e->getMessage()) . "</pre>
                  </div>";
        } else {
            echo "<h1>A technical error has occurred. Please try again later....</h1>";
        }
        exit;
    }
}