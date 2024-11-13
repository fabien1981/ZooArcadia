<?php

use App\Routing\Router;

require_once __DIR__ . '/vendor/autoload.php';

session_start();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;

if (file_exists($file) && is_file($file)) {
    return false; // Sert directement le fichier statique sans passer par le router
}

$error = null;
$router = new Router($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
$data = $router->doAction();

if ($router->isReturnJson()) {
    header('Content-Type: application/json');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
} else {
    if (is_string($data)) {
        $data = json_decode($data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("Erreur JSON : " . json_last_error_msg());
            echo "Erreur : données JSON invalides.";
            exit;
        }
    }

    if (is_array($data)) {
        $error = $data['message'] ?? null;
        $page = 'templates/' . ($data['template'] ?? 'default') . '.php';
        if (file_exists('templates/base_template.php')) {
            require_once 'templates/base_template.php';
        } else {
            echo "Erreur : le fichier de base du template est introuvable.";
        }
    } else {
        echo "Erreur : format de réponse inattendu.";
    }
}
