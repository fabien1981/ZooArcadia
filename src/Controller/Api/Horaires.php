<?php

namespace App\Controller\Api;

use App\Database\Dbutils;
use PDO;
use Exception;

class Horaires
{
    // Autres méthodes...

    public function create(array $data): array
    {
        // Validation des données
        if (empty($data['period']) || empty($data['closing_cashier']) || empty($data['closing_foot_park'])) {
            return ['success' => false, 'message' => 'Tous les champs sont requis pour créer un horaire.'];
        }

        try {
            $query = Dbutils::getPdo()->prepare(
                'INSERT INTO horaires (period, closing_cashier, closing_foot_park) 
                VALUES (:period, :closing_cashier, :closing_foot_park)'
            );
            $query->bindParam(':period', $data['period']);
            $query->bindParam(':closing_cashier', $data['closing_cashier']);
            $query->bindParam(':closing_foot_park', $data['closing_foot_park']);
            $query->execute();

            return ['success' => true, 'message' => 'Horaire ajouté avec succès'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de la création de l\'horaire : ' . $e->getMessage()];
        }
    }
}
