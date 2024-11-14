<?php

namespace App\Controller\Api;

use App\Database\Dbutils;
use PDO;
use Exception;

class Animal
{
    public function list(): array
    {
        try {
            $query = Dbutils::getPdo()->prepare('
                SELECT animal.*, habitat.nom AS habitat_nom
                FROM animal
                JOIN habitat ON animal.habitat = habitat.habitat_id
            ');
            $query->execute();
            $animaux = $query->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'data' => $animaux
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la récupération des animaux : ' . $e->getMessage()
            ];
        }
    }

    public function getHabitats(): array
    {
        try {
            $query = Dbutils::getPdo()->prepare('SELECT * FROM habitat');
            $query->execute();
            $habitats = $query->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'message' => $habitats ? '' : 'Aucun habitat disponible',
                'data' => $habitats
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la récupération des habitats : ' . $e->getMessage(),
                'data' => null
            ];
        }
    }
}
