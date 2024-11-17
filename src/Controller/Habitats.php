<?php

namespace App\Controller;

use App\Database\Dbutils;
use Exception;
use PDO;

class Habitats
{
    public function display(): array
    {
        try {
            $query = Dbutils::getPdo()->prepare('SELECT * FROM habitat');
            $query->execute();
            $habitats = $query->fetchAll(PDO::FETCH_ASSOC);

            return [
                'template' => 'home/habitats', // Vue pour la liste des habitats
                'habitats' => $habitats // Données à transmettre à la vue
            ];
        } catch (Exception $e) {
            return [
                'template' => 'error', // Page d'erreur
                'message' => 'Erreur lors de la récupération des habitats : ' . $e->getMessage()
            ];
        }
    }

    public function show(int $id): array
    {
        try {
            // Récupérer les détails de l'habitat
            $query = Dbutils::getPdo()->prepare('SELECT * FROM habitat WHERE habitat_id = :id');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $habitat = $query->fetch(PDO::FETCH_ASSOC);

            if (!$habitat) {
                return [
                    'template' => 'error',
                    'message' => 'Habitat introuvable.'
                ];
            }

            // Récupérer les animaux associés à l'habitat
            $query = Dbutils::getPdo()->prepare('
                SELECT animal_id, prenom, race, etat 
                FROM animal 
                WHERE habitat = :id
            ');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $animaux = $query->fetchAll(PDO::FETCH_ASSOC);

            return [
                'template' => 'habitat_detail', // Vue pour les détails de l'habitat
                'habitat' => $habitat, // Détails de l'habitat
                'animaux' => $animaux // Animaux de l'habitat
            ];
        } catch (Exception $e) {
            return [
                'template' => 'error',
                'message' => 'Erreur lors de la récupération des détails de l\'habitat : ' . $e->getMessage()
            ];
        }
    }
}
