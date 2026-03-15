<?php
define('APP_ROOT', dirname(__DIR__));
define('APP_PUBLIC', __DIR__);
if (file_exists(APP_ROOT . '/.env')) {
    $lines = file(APP_ROOT . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}
$isDebug = getenv('APP_DEBUG') === 'true';
define('APP_DEBUG', $isDebug);

if (APP_DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', APP_ROOT . '/storage/logs/php-error.log');
}

date_default_timezone_set('Africa/Dar_es_Salaam');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
spl_autoload_register(function ($class) {
    $namespaces = [
        'App\\' => APP_ROOT . '/App',
        'Bootstrap\\' => APP_ROOT . '/Bootstrap',
        'Config\\' => APP_ROOT . '/Config'
    ];
    foreach ($namespaces as $prefix => $baseDir) {
        if (strpos($class, $prefix) === 0) {
            $relativeClass = substr($class, strlen($prefix));
            $file = $baseDir . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }
});
try {
    $app = new \Bootstrap\App();
    $app->run();
} catch (\Exception $e) {
    error_log("Fatal Error: " . $e->getMessage());
    http_response_code(500);
    
    $isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Server Error', 'message' => APP_DEBUG ? $e->getMessage() : 'Technical error occurred.']);
    } else {
        die(APP_DEBUG ? "Fatal Error: " . $e->getMessage() : "A technical error has occurred. Please try again later..");
    }
}