<?php

namespace App\Controller\Api;

use App\Database\DbConnectionNoSQL;

class ConsultationController
{
    public function incrementConsultation()
    {
        $animalId = $_POST['animal_id'] ?? null;
        $animalName = $_POST['animal_name'] ?? null;
        $habitatName = $_POST['habitat_name'] ?? null;

        if (!$animalId || !$animalName || !$habitatName) {
            echo json_encode(['success' => false, 'message' => 'Données manquantes']);
            return;
        }

        $db = DbConnectionNoSQL::getDB();
        $collection = $db->consultations;

        $existingRecord = $collection->findOne(['animal_id' => (int)$animalId]);

        if ($existingRecord) {
            $collection->updateOne(
                ['animal_id' => (int)$animalId],
                ['$inc' => ['consultations' => 1]]
            );
        } else {
            $collection->insertOne([
                'animal_id' => (int)$animalId,
                'animal_name' => $animalName,
                'habitat_name' => $habitatName,
                'consultations' => 1
            ]);
        }

        echo json_encode(['success' => true]);
    }
}
