<?php

namespace App\Controller;

use App\Database\Dbutils;
use PDO;
use Exception;

class Animals
{
    public function show(int $id): array
{
    try {
        // Récupérer les détails de l'animal
        $query = Dbutils::getPdo()->prepare('
            SELECT animal.*, habitat.nom AS habitat_nom
            FROM animal
            JOIN habitat ON animal.habitat = habitat.habitat_id
            WHERE animal_id = :id
        ');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $animal = $query->fetch(PDO::FETCH_ASSOC);

        if (!$animal) {
            throw new Exception('Animal introuvable.');
        }

        // Ajoutez l'ID de l'habitat au retour pour la vue
        $habitatId = $_GET['habitat_id'] ?? null;

        return [
            'template' => 'animal_detail', // Vue pour les détails de l'animal
            'animal' => $animal,
            'habitat_id' => $habitatId // Transmettre l'ID de l'habitat à la vue
        ];
    } catch (Exception $e) {
        return [
            'template' => 'error',
            'message' => $e->getMessage()
        ];
    }
}
}
