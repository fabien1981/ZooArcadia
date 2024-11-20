<?php

namespace App\Controller\Api;

use App\Database\DbConnectionNoSQL;
use Exception;

class ConsultationController
{


    public function incrementConsultation()
{
    try {
        $input = file_get_contents('php://input'); // 
        $data = json_decode($input, true); // Décoder les données JSON

        error_log("Données JSON reçues : " . json_encode($data)); // Journaliser les données reçues

        $animalId = $data['animal_id'] ?? null;
        $animalName = $data['animal_name'] ?? null;
        $habitatName = $data['habitat_name'] ?? null;

        if (!$animalId || !$animalName || !$habitatName) {
            error_log("Données manquantes dans incrementConsultation");
            echo json_encode(['success' => false, 'message' => 'Données manquantes']);
            return;
        }

        $db = DbConnectionNoSQL::getDB(); // Connexion à MongoDB
        $collection = $db->consultations;

        // Rechercher l'enregistrement correspondant
        $existingRecord = $collection->findOne(['animal_id' => (int)$animalId]);

        if ($existingRecord) {
            // Incrémenter le champ `consultations`
            $collection->updateOne(
                ['animal_id' => (int)$animalId],
                ['$inc' => ['consultations' => 1]]
            );
            error_log("Consultations incrémentées pour animal_id = $animalId");
        } else {
            // Créer un nouvel enregistrement si non existant
            $collection->insertOne([
                'animal_id' => (int)$animalId,
                'animal_name' => $animalName,
                'habitat_name' => $habitatName,
                'consultations' => 1, // Initialise à 1
            ]);
            error_log("Nouvel enregistrement créé pour animal_id = $animalId");
        }

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        error_log("Erreur dans incrementConsultation : " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
    }
}



public function getStatistics()
{
    try {
        $db = DbConnectionNoSQL::getDB(); // Connexion à MongoDB
        $collection = $db->consultations;

        // Vérifier les documents sans clé `consultations`
        $this->ajouterChampConsultations($collection);

        // Récupérer toutes les données
        $stats = $collection->find()->toArray();

        error_log("Statistiques récupérées : " . json_encode($stats));
        return ['success' => true, 'data' => $stats];
    } catch (Exception $e) {
        error_log("Erreur dans getStatistics : " . $e->getMessage());
        return ['success' => false, 'message' => 'Erreur serveur'];
    }
}




private function ajouterChampConsultations($collection)
{
    try {
       
        error_log("Vérification et mise à jour des documents sans la clé 'consultations'...");

       
        $result = $collection->updateMany(
            ['consultations' => ['$exists' => false]], // Condition : champ `consultations` inexistant
            ['$set' => ['consultations' => 0]]        // Ajoute la clé `consultations` avec une valeur par défaut de 0
        );

        // Journaliser le nombre de documents mis à jour
        error_log("Documents mis à jour pour ajouter 'consultations' : " . $result->getModifiedCount());
    } catch (Exception $e) {
        // Journaliser l'erreur en cas d'échec
        error_log("Erreur dans ajouterChampConsultations : " . $e->getMessage());
        throw $e; // Relancer l'exception pour la gérer dans `getStatistics`
    }
}




}
