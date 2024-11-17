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

    public function delete(int $id): array
{
    try {
        $query = Dbutils::getPdo()->prepare('DELETE FROM animal WHERE animal_id = :id');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        return ['success' => true];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erreur lors de la suppression de l\'animal : ' . $e->getMessage()];
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

    public function create(array $data): array
    {
        if (empty($data['prenom']) || empty($data['race']) || empty($data['etat']) || empty($data['habitat'])) {
            return ['success' => false, 'message' => 'Tous les champs sont requis.'];
        }

        try {
            $query = Dbutils::getPdo()->prepare('INSERT INTO animal (prenom, race, etat, image_animal, habitat) VALUES (:prenom, :race, :etat, :image_animal, :habitat)');
            $query->bindParam(':prenom', $data['prenom']);
            $query->bindParam(':race', $data['race']);
            $query->bindParam(':etat', $data['etat']);
            $query->bindParam(':image_animal', $data['image_animal']);
            $query->bindParam(':habitat', $data['habitat']);
            $query->execute();

            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de l\'ajout de l\'animal : ' . $e->getMessage()];
        }
    }

    public function edit(int $id, array $data): array
    {
        if (empty($data['prenom']) || empty($data['race']) || empty($data['etat']) || empty($data['habitat'])) {
            return ['success' => false, 'message' => 'Tous les champs sont requis.'];
        }

        try {
            $query = Dbutils::getPdo()->prepare('UPDATE animal SET prenom = :prenom, race = :race, etat = :etat, image_animal = :image_animal, habitat = :habitat WHERE animal_id = :id');
            $query->bindParam(':prenom', $data['prenom']);
            $query->bindParam(':race', $data['race']);
            $query->bindParam(':etat', $data['etat']);
            $query->bindParam(':image_animal', $data['image_animal']);
            $query->bindParam(':habitat', $data['habitat']);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Erreur lors de la mise à jour de l\'animal : ' . $e->getMessage()];
        }
    }

    public function show(int $id): array
{
    try {
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
            return ['success' => false, 'message' => 'Animal introuvable.'];
        }

        return ['success' => true, 'data' => $animal];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erreur : ' . $e->getMessage()];
    }
}

}
