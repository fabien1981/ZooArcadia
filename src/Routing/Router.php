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
        $uri = trim($uri, '/');

        // Ignore les fichiers statiques
        if (preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|ico)$/i', $uri)) {
            return;
        }

        // Supprime le préfixe "811" de l'URI si présent
        if (strpos($uri, '811') === 0) {
            $uri = substr($uri, 4);
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

                if ($uriExplode[0] === 'list') {
                    $this->method = 'list';
                    return;
                }

                if ($uriExplode[0] === 'create') {
                    $this->method = 'create';
                    return;
                }

                if ($uriExplode[0] === 'edit' && isset($uriExplode[1])) {
                    $this->method = 'edit';
                    $this->parameter = (int)$uriExplode[1];
                    return;
                }

                if ($uriExplode[0] === 'delete' && isset($uriExplode[1])) {
                    $this->method = 'delete';
                    $this->parameter = (int)$uriExplode[1];
                    return;
                }

                if ($uriExplode[0] === 'show' && isset($uriExplode[1])) {
                    $this->method = 'show';
                    $this->parameter = (int)$uriExplode[1];
                    return;
                }
            }
        }

        // Route pour afficher le formulaire de création de compte
        if ($uri === 'admin/creation-compte') {
            $this->controllerName .= 'Admin';
            $this->method = 'afficherFormulaireCreationCompte';
            return;
        }

        // Route pour traiter la création de compte utilisateur
        if ($uri === 'admin/creer-compte') {
            $this->controllerName .= 'CreerCompte';
            $this->method = 'creerCompte';
            $this->returnJson = true;
            return;
        }

        // Route pour accéder aux habitats
        if ($uri === 'api/animal/habitats') {
            $this->controllerName .= 'Api\\Animal';
            $this->method = 'getHabitats';
            $this->returnJson = true;
            return;
        }
        

        // Route pour accéder à la gestion des animaux
        if ($uri === 'admin/gestion-animaux') {
            $this->controllerName .= 'Admin';
            $this->method = 'gestionAnimaux';
            return;
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

        // Récupérer les données en JSON pour PUT ou POST, ou via $_POST pour les formulaires HTML
        $data = null;

        if ($this->requestMethod === 'POST' || $this->requestMethod === 'PUT') {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

            if (strpos($contentType, 'application/json') !== false) {
                // Requête JSON
                $data = json_decode(file_get_contents('php://input'), true);
            } else {
                // Formulaire HTML
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

    public function isReturnJson(): bool
    {
        return $this->returnJson;
    }
}
