<?php

namespace App\Controller\Api;

use App\Database\Dbutils;
use PDO;
use Exception;

class Horaires
{
    // Liste des horaires
    public function list(): array
    {
        try {
            $pdo = Dbutils::getPdo();
            $query = $pdo->prepare('SELECT * FROM horaires ORDER BY id');
            $query->execute();
            $horaires = $query->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'data' => $horaires
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la récupération des horaires : ' . $e->getMessage()
            ];
        }
    }

    // Création d'un nouvel horaire
    public function create(array $data): array
    {
        try {
            $pdo = Dbutils::getPdo();
            $query = $pdo->prepare('INSERT INTO horaires (period, closing_cashier, closing_foot_park) VALUES (:period, :closing_cashier, :closing_foot_park)');
            $query->bindParam(':period', $data['period']);
            $query->bindParam(':closing_cashier', $data['closing_cashier']);
            $query->bindParam(':closing_foot_park', $data['closing_foot_park']);
            $query->execute();

            return [
                'success' => true,
                'message' => 'Horaire ajouté avec succès'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de l\'ajout de l\'horaire : ' . $e->getMessage()
            ];
        }
    }

    // Modification d'un horaire existant
    public function edit(int $id, array $data): array
    {
        try {
            $pdo = Dbutils::getPdo();
            $query = $pdo->prepare('UPDATE horaires SET period = :period, closing_cashier = :closing_cashier, closing_foot_park = :closing_foot_park WHERE id = :id');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->bindParam(':period', $data['period']);
            $query->bindParam(':closing_cashier', $data['closing_cashier']);
            $query->bindParam(':closing_foot_park', $data['closing_foot_park']);
            $query->execute();

            return [
                'success' => true,
                'message' => 'Horaire modifié avec succès'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la modification de l\'horaire : ' . $e->getMessage()
            ];
        }
    }

    // Suppression d'un horaire
    public function delete(int $id): array
    {
        try {
            $pdo = Dbutils::getPdo();
            $query = $pdo->prepare('DELETE FROM horaires WHERE id = :id');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            return [
                'success' => true,
                'message' => 'Horaire supprimé avec succès'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la suppression de l\'horaire : ' . $e->getMessage()
            ];
        }
    }
}
