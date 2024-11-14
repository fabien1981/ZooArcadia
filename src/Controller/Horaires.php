<?php

namespace App\Controller;

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

    public function show(int $id): array
    {
        try {
            $query = Dbutils::getPdo()->prepare('SELECT * FROM horaires WHERE id = :id');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $hour = $query->fetch(PDO::FETCH_ASSOC);

            return [
                'success' => !empty($hour),
                'data' => $hour,
                'message' => $hour ? '' : "L'horaire n'a pas été trouvé."
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la récupération de l\'horaire : ' . $e->getMessage()
            ];
        }
    }

    public function create(array $data): array
    {
        // Validation des données
        if (empty($data['period']) || empty($data['closing_cashier']) || empty($data['closing_foot_park'])) {
            return ['success' => false, 'message' => 'Tous les champs sont requis pour créer un horaire.'];
        }

        try {
            $query = Dbutils::getPdo()->prepare('INSERT INTO horaires (period, closing_cashier, closing_foot_park) VALUES (:period, :closing_cashier, :closing_car_park, :closing_foot_park)');
            $query->bindParam(':period', $data['period']);
            $query->bindParam(':closing_cashier', $data['closing_cashier']);
           
            $query->bindParam(':closing_foot_park', $data['closing_foot_park']);
            $query->execute();

            return ['success' => true, 'message' => 'Horaire ajouté avec succès'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de la création de l\'horaire : ' . $e->getMessage()];
        }
    }

    public function edit(int $id, array $data): array
    {
        // Validation des données
        if (empty($data['period']) || empty($data['closing_cashier']) || empty($data['closing_car_park']) || empty($data['closing_foot_park'])) {
            return ['success' => false, 'message' => 'Tous les champs sont requis pour modifier un horaire.'];
        }

        try {
            $query = Dbutils::getPdo()->prepare('UPDATE horaires SET period = :period, closing_cashier = :closing_cashier, closing_car_park = :closing_car_park, closing_foot_park = :closing_foot_park WHERE id = :id');
            $query->bindParam(':period', $data['period']);
            $query->bindParam(':closing_cashier', $data['closing_cashier']);
            $query->bindParam(':closing_car_park', $data['closing_car_park']);
            $query->bindParam(':closing_foot_park', $data['closing_foot_park']);
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
