<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


use App\Routing\Router;
use Dotenv\Dotenv;

require_once __DIR__ . '/config/session.php';
require_once __DIR__ . '/vendor/autoload.php';




// Initialiser le routeur
$router = new Router($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
$router->add('/test/mongodb', [App\Controller\Test::class, 'mongodb']);


$router->get('/veterinaire/display', [\App\Controller\Veterinaire::class, 'display']);



// Routes API pour la gestion des animaux
$router->get('/api/animal/list', [\App\Controller\Api\Animal::class, 'list']);
$router->get('/api/animal/show/{id}', [\App\Controller\Api\Animal::class, 'show']);
$router->post('/api/animal/create', [\App\Controller\Api\Animal::class, 'create']);
$router->put('/api/animal/edit/{id}', [\App\Controller\Api\Animal::class, 'edit']);
$router->delete('/api/animal/delete/{id}', [\App\Controller\Api\Animal::class, 'delete']);
$router->get('/api/animal/habitats', [\App\Controller\Api\Animal::class, 'getHabitats']);

// Routes pour la gestion des habitats
$router->get('/habitats/display', [\App\Controller\Habitats::class, 'display']);
$router->get('/habitats/show/{id}', [\App\Controller\Habitats::class, 'show']);

// Routes pour l'interface admin
$router->get('/admin/display', [\App\Controller\Admin::class, 'display']);
$router->get('/admin/creation_compte', [\App\Controller\Admin::class, 'creationCompte']);
$router->post('/admin/creer_compte', [\App\Controller\Admin::class, 'creerCompte']);
$router->get('/admin/gestion_animaux', [\App\Controller\Admin::class, 'gestionAnimaux']);
$router->get('/admin/gestion_horaires', [\App\Controller\Admin::class, 'gestionHoraires']);
$router->get('/admin/statistiques_consultations', [\App\Controller\Admin::class, 'statistiquesConsultations']);
$router->get('/admin/gestion_services', [\App\Controller\Admin::class, 'gestionServices']);
$router->post('/admin/add_service', [\App\Controller\Admin::class, 'addService']);
$router->get('/admin/edit_service/{id}', [\App\Controller\Admin::class, 'editService']);
$router->get('/admin/delete_service/{id}', [\App\Controller\Admin::class, 'deleteService']);

// Routes employé et alimentation
$router->get('/employe', [\App\Controller\Employe::class, 'display']);
$router->get('/nourrir', [\App\Controller\Employe::class, 'nourrir']);


// Routes pour les statistiques API
$router->get('/api/consultation/statistics', [\App\Controller\Api\ConsultationController::class, 'getStatistics']);
$router->post('/api/consultation/increment', [\App\Controller\Api\ConsultationController::class, 'incrementConsultation']);

// Exécuter l'action basée sur la route
try {
    $data = $router->doAction();

    // Gestion des erreurs de réponse
    if (is_string($data)) {
        $data = json_decode($data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "Erreur : données JSON invalides.";
            exit;
        }
    }

    // Rendu de la page
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
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
