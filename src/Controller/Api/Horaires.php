<?php

namespace App\Controller\Api;

use App\Database\Dbutils;
use PDO;
use Exception;

class Horaires
{
    public function list(): array
    {
        try {
            $query = Dbutils::getPdo()->prepare('SELECT * FROM horaires');
            $query->execute();
            $hours = $query->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'data' => $hours
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la récupération des horaires : ' . $e->getMessage()
            ];
        }
    }

    public function create(array $data): array
    {
        // Validation des données
        if (empty($data['periode']) || empty($data['fermeture_caisses']) || empty($data['fermeture_parc_pied'])) {
            return ['success' => false, 'message' => 'Tous les champs sont requis pour créer un horaire.'];
        }

        try {
            $query = Dbutils::getPdo()->prepare(
                'INSERT INTO horaires (periode, fermeture_caisses, fermeture_parc_pied) 
                 VALUES (:periode, :fermeture_caisses, :fermeture_parc_pied)'
            );
            $query->bindParam(':periode', $data['periode']);
            $query->bindParam(':fermeture_caisses', $data['fermeture_caisses']);
            $query->bindParam(':fermeture_parc_pied', $data['fermeture_parc_pied']);
            $query->execute();

            return ['success' => true, 'message' => 'Horaire ajouté avec succès'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de la création de l\'horaire : ' . $e->getMessage()];
        }
    }

    public function edit(int $id, array $data): array
    {
        if (empty($data['periode']) || empty($data['fermeture_caisses']) || empty($data['fermeture_parc_pied'])) {
            return ['success' => false, 'message' => 'Tous les champs sont requis pour modifier un horaire.'];
        }

        try {
            $query = Dbutils::getPdo()->prepare(
                'UPDATE horaires 
                 SET periode = :periode, fermeture_caisses = :fermeture_caisses, fermeture_parc_pied = :fermeture_parc_pied 
                 WHERE id = :id'
            );
            $query->bindParam(':periode', $data['periode']);
            $query->bindParam(':fermeture_caisses', $data['fermeture_caisses']);
            $query->bindParam(':fermeture_parc_pied', $data['fermeture_parc_pied']);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            return ['success' => true, 'message' => 'Horaire modifié avec succès'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de la modification de l\'horaire : ' . $e->getMessage()];
        }
    }

    public function delete(int $id): array
    {
        try {
            $query = Dbutils::getPdo()->prepare('DELETE FROM horaires WHERE id = :id');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            return ['success' => true, 'message' => 'Horaire supprimé avec succès'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de la suppression de l\'horaire : ' . $e->getMessage()];
        }
    }
}
