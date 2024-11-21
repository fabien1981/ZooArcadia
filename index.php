<?php
use App\Routing\Router;
use Dotenv\Dotenv;
use MongoDB\Client;


require_once __DIR__ . '/config/session.php';
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


$router = new Router($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

// Enregistrer les routes
$router->get('/habitats/display', ['App\\Controller\\Habitats', 'display']);


$router->get('/employe', [\App\Controller\Employe::class, 'display']);
$router->get('/nourrir', [\App\Controller\Employe::class, 'nourrir']);
$router->get('/admin/creation_compte', [\App\Controller\Admin::class, 'creationCompte']);
$router->get('/admin/gestion_animaux', [\App\Controller\Admin::class, 'gestionAnimaux']);
$router->get('/admin/gestion_horaires', [\App\Controller\Admin::class, 'gestionHoraires']);
$router->post('/admin/creer_compte', [\App\Controller\Admin::class, 'creerCompte']);

// Exécuter l'action basée sur la route
$data = $router->doAction();

if (is_string($data)) {
    $data = json_decode($data, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
      //  error_log("Erreur JSON : " . json_last_error_msg());
        echo "Erreur : données JSON invalides.";
        exit;
    }
}

if (is_array($data)) {
    $template = $data['template'] ?? 'default';
    $page = __DIR__ . '/templates/' . $template . '.php';

    if (file_exists(__DIR__ . '/templates/base_template.php')) {
        extract($data);
        require_once __DIR__ . '/templates/base_template.php';
    } else {
        echo "Erreur : le fichier de base du template est introuvable.";
    }
} else {
    echo "Erreur : format de réponse inattendu.";
}
