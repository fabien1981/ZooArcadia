<?php

namespace App\Routing;

use Exception;

class Router
{
    private string $controllerName = "App\\Controller\\";
    private ?string $method;
    private ?string $parameter = null;
    private bool $returnJson = false;

    public function __construct(private $requestMethod, string $uri)
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = ltrim($uri, '/');

        // Ignore les fichiers statiques
        if (preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|ico)$/i', $uri)) {
            return;
        }

        // Route pour 'add-nourriture'
        if ($uri === 'add-nourriture' && $this->requestMethod === 'POST') {
            $this->controllerName = 'App\\Controller\\NourritureController';
            $this->method = 'addNourriture';
            return;
        }

        // Supprime le préfixe "ZooArcadia" de l'URI si présent
        if (strpos($uri, 'ZooArcadia') === 0) {
            $uri = substr($uri, strlen('ZooArcadia') + 1);
        }

        // Routes spécifiques pour les actions liées aux employés
        if ($uri === 'employe') {
            $this->controllerName = 'App\\Controller\\Employe';
            $this->method = 'display';
            return;
        }

        if ($uri === 'nourrir' && isset($_GET['animal_id'])) {
            $this->controllerName = 'App\\Controller\\Employe';
            $this->method = 'nourrir';
            return;
        }

        if ($uri === 'add-nourriture' && $this->requestMethod === 'POST') {
            $this->controllerName = 'App\\Controller\\NourritureController';
            $this->method = 'addNourriture';
            return;
        }

        // Routes spécifiques pour la déconnexion
        if ($uri === 'logout') {
            $this->controllerName .= 'Logout';
            $this->method = 'logout';
            return;
        }

        // Route par défaut pour l'accueil
        if ($uri === '') {
            $uri = 'homepage/home';
        }

        $uriExplode = explode('/', $uri);

        // Gestion des routes d'API
        if ('api' === $uriExplode[0]) {
            $this->returnJson = true;
            array_shift($uriExplode);

            if ($uriExplode[0] === 'animal') {
                $this->controllerName .= 'Api\\Animal';
                array_shift($uriExplode);

                switch ($uriExplode[0]) {
                    case 'list':
                        $this->method = 'list';
                        break;
                    case 'create':
                        $this->method = 'create';
                        break;
                    case 'edit':
                        $this->method = 'edit';
                        $this->parameter = isset($uriExplode[1]) ? (int)$uriExplode[1] : null;
                        break;
                    case 'delete':
                        $this->method = 'delete';
                        $this->parameter = isset($uriExplode[1]) ? (int)$uriExplode[1] : null;
                        break;
                    case 'show':
                        $this->method = 'show';
                        $this->parameter = isset($uriExplode[1]) ? (int)$uriExplode[1] : null;
                        break;
                    case 'habitats':
                        $this->method = 'getHabitats';
                        break;
                    default:
                        throw new Exception("Route non reconnue pour 'animal'");
                }
                return;
            }
        }

        // Routage par défaut pour les autres URI
        $uriLength = count($uriExplode);

        if ($uriLength === 0 || empty($uriExplode[0])) {
            $this->controllerName .= 'Homepage';
            $this->method = 'home';
            return;
        }

        // Vérification des paramètres
        if (is_numeric(end($uriExplode))) {
            $this->parameter = array_pop($uriExplode);
        }

        // Définit le contrôleur et la méthode
        $this->method = array_pop($uriExplode) ?: 'index';
        $uriLength = count($uriExplode);

        $counter = 1;
        foreach ($uriExplode as $uriPart) {
            if (!$uriPart) {
                continue;
            }

            $separator = ($counter === $uriLength) ? '' : '\\';
            $this->controllerName .= ucfirst($uriPart) . $separator;
            $counter++;
        }

        if ($this->controllerName === "App\\Controller\\") {
            $this->controllerName .= 'Homepage';
            $this->method = 'home';
        }
    }

    public function post($route, $action)
{
    $currentRoute = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $route = trim($route, '/');

    if ($this->requestMethod === 'POST' && $currentRoute === $route) {
        $this->controllerName = $action[0];
        $this->method = $action[1];
    }
}

public function isReturnJson(): bool
{
    return $this->returnJson;
}

    public function get($route, $action)
{
    $currentRoute = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $route = trim($route, '/');

    if ($this->requestMethod === 'GET' && $currentRoute === $route) {
        $this->controllerName = $action[0];
        $this->method = $action[1];
    }
}


    public function doAction(): array|string
    {
        $controllerName = $this->controllerName;
        $method = $this->method;

        if (empty($method) || $controllerName === "App\\Controller\\") {
            throw new Exception("Contrôleur ou méthode invalide.");
        }

        if (!class_exists($controllerName)) {
            throw new Exception("La classe du contrôleur '$controllerName' est introuvable.");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $method)) {
            throw new Exception("La méthode '$method' n'est pas trouvée dans le contrôleur '$controllerName'.");
        }

        $data = null;

        if ($this->requestMethod === 'POST' || $this->requestMethod === 'PUT') {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

            if (strpos($contentType, 'application/json') !== false) {
                $data = json_decode(file_get_contents('php://input'), true);
            } else {
                $data = $_POST;
            }
        }

        $result = $this->parameter !== null
            ? $controller->$method($this->parameter, $data)
            : $controller->$method($data);

        if ($this->returnJson) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit;
        }

        return is_array($result) ? $result : (string) $result;
    }
}
