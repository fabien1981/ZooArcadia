<?php
use App\Routing\Router;
use App\Controller\Habitats;

require_once __DIR__ . '/config/session.php';
require_once __DIR__ . '/vendor/autoload.php';

$router = new Router($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

// Enregistrer la route /ZooArcadia/habitats
$router->get('ZooArcadia/habitats', [Habitats::class, 'display']);
$router->post('add-nourriture', [\App\Controller\NourritureController::class, 'addNourriture']);
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
        $template = $data['template'] ?? 'default';
        $page = __DIR__ . '/templates/' . $template . '.php';

        if (file_exists(__DIR__ . '/templates/base_template.php')) {
            // Vérifiez que 'data' est un tableau avant d'utiliser extract
            if (isset($data['data']) && is_array($data['data'])) {
                extract($data['data']);
            } else {
                $data['data'] = []; // Assurez-vous que $data['data'] est un tableau vide si non défini
            }
            require_once __DIR__ . '/templates/base_template.php';
        } else {
            echo "Erreur : le fichier de base du template est introuvable.";
        }
    } else {
        echo "Erreur : format de réponse inattendu.";
    }
}
