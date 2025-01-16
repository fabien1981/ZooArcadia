<?php

namespace App\Controller\Api;

use App\Database\DbConnectionNoSQL;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;




class Avis
{
    private $collection;

    public function __construct()
{
    try {
        $this->collection = DbConnectionNoSQL::getDB()->avis;
       
    } catch (\Exception $e) {
        echo 'Erreur de connexion MongoDB : ' . $e->getMessage();
        exit;
    }
}

    /*
     * Méthode pour créer un avis
     */
    public function create(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST;

        // Vérifier que tous les champs requis sont remplis
        if (empty($data['pseudo']) || empty($data['avis']) || empty($data['rating'])) {
            echo 'Tous les champs sont requis.';
            return;
        }

        try {
            // Préparation des données à insérer
            $avis = [
                'pseudo' => htmlspecialchars($data['pseudo']),
                'avis' => htmlspecialchars($data['avis']),
                'rating' => (int)$data['rating'],
                'date_created' => new \MongoDB\BSON\UTCDateTime(),
                'is_validated' => false // Initialiser comme non validé
            ];

            // Insertion dans la collection MongoDB
            $this->collection->insertOne($avis);

            // Ajouter un message de succès dans la session
            session_start();
            $_SESSION['success_message'] = 'Votre avis a bien été envoyé.';

            // Redirection vers la page d'accueil
            header('Location: /homepage/home');
            exit;
        } catch (\Exception $e) {
            echo 'Erreur lors de l\'enregistrement : ' . $e->getMessage();
        }
    } else {
        echo 'Méthode non autorisée.';
    }
}






    /*
     * Méthode pour lister tous les avis
     */
    public function list(): array
{
    try {
        $avis = $this->collection->find(['is_validated' => true], ['sort' => ['date_created' => -1]])->toArray();

        // Conversion des objets BSON en tableau PHP
        $avis = array_map(function ($item) {
            $item['_id'] = (string) $item['_id']; // Convertit ObjectId en chaîne
            $item['date_created'] = $item['date_created']->toDateTime()->format('Y-m-d H:i:s'); // Convertit UTCDateTime
            return $item;
        }, $avis);

        return [
            'success' => true,
            'data' => $avis
        ];
    } catch (\Exception $e) {
        error_log('Erreur MongoDB : ' . $e->getMessage());
        return [
            'success' => false,
            'message' => 'Erreur lors de la récupération des avis : ' . $e->getMessage()
        ];
    }
}



    
    

    /*
     * Méthode pour supprimer un avis
     */
    public function delete(string $id): array
    {
        try {
            $result = $this->collection->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

            if ($result->getDeletedCount() > 0) {
                return ['success' => true, 'message' => 'Avis supprimé avec succès.'];
            }

            return ['success' => false, 'message' => 'Aucun avis trouvé avec cet ID.'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de la suppression : ' . $e->getMessage()];
        }
    }

    /*
     * Méthode pour préparer les données pour les templates
     */
    public function listAvis(): void
{
    try {
        // Récupérer les avis via la méthode list()
        $avisData = $this->list();

        if ($avisData['success']) {
            $avis = $avisData['data']; // Données des avis
            $page = __DIR__ . '/../../../templates/avis_list.php'; // Chemin vers le fichier de contenu
        } else {
            $avis = [];
            $page = __DIR__ . '/../../../templates/error.php'; // Chemin vers un fichier d'erreur si la récupération échoue
            $errorMessage = $avisData['message'];
        }

        // Inclure la base template
        require_once __DIR__ . '/../../../templates/base_template.php';
    } catch (\Exception $e) {
        if (getenv('APP_DEBUG') === 'true') {
            var_dump($e->getMessage()); // Debug : affiche l'erreur
        }
        echo '<div class="container mt-5"><p class="text-danger">Erreur lors de la récupération des avis : ' . htmlspecialchars($e->getMessage()) . '</p></div>';
    }
}





public function displayForm(): array
{
    return [
        'template' => 'avis_form', // Remplacez 'avis_form' par le nom exact de votre fichier template sans extension.
        'message' => 'Laisser un avis'
    ];
}

}
