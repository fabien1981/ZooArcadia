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
        // Récupération de la collection "avis" via la connexion centralisée
        $this->collection = DbConnectionNoSQL::getDB()->avis;
    }
    

    /*
     * Méthode pour créer un avis
     */
    public function create(array $data = null): array
{
    // Récupérer le JSON envoyé
    if ($data === null) {
        $data = json_decode(file_get_contents('php://input'), true);
    }

    if (empty($data['pseudo']) || empty($data['avis']) || empty($data['rating'])) {
        return ['success' => false, 'message' => 'Tous les champs sont requis.'];
    }

    try {
        $avis = [
            'pseudo' => DbConnectionNoSQL::protectDbData($data['pseudo']),
            'avis' => DbConnectionNoSQL::protectDbData($data['avis']),
            'rating' => (int)DbConnectionNoSQL::protectDbData($data['rating']),
            'date_created' => new \MongoDB\BSON\UTCDateTime()
        ];

        $this->collection->insertOne($avis);

        return ['success' => true, 'message' => 'Merci pour votre avis !'];
    } catch (\Exception $e) {
        return ['success' => false, 'message' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage()];
    }
}



    /*
     * Méthode pour lister tous les avis
     */
    public function list(): array
    {
        try {
            $avis = $this->collection->find([], ['sort' => ['date_created' => -1]])->toArray();

            return [
                'success' => true,
                'data' => $avis
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de la récupération des avis : ' . $e->getMessage()];
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
    public function listAvis(): array
{
    try {
        // Appelle la méthode list() pour récupérer les avis
        $avisData = $this->list();

        if ($avisData['success']) {
            return [
                'template' => 'avis_list', // Nom du fichier template situé dans templates/
                'avis' => $avisData['data'], // Les données des avis
            ];
        } else {
            return [
                'template' => 'error', // Nom d'un template d'erreur si la récupération échoue
                'message' => $avisData['message'],
            ];
        }
    } catch (\Exception $e) {
        return [
            'template' => 'error',
            'message' => 'Erreur lors de la récupération des avis : ' . $e->getMessage(),
        ];
    }
}


    public function displayForm(): void
{
    // Chemin vers votre fichier de formulaire
    include __DIR__ . '/../../../templates/avis.php';

}

}
