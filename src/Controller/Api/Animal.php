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
            $query = Dbutils::getPdo()->prepare('SELECT * FROM animal');
            $query->execute();
            $animaux = $query->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'message' => $animaux ? '' : 'Aucun animal présent dans la base',
                'data' => $animaux
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la récupération des animaux : ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    public function show(int $id): array
    {
        try {
            $query = Dbutils::getPdo()->prepare('SELECT * FROM animal WHERE animal_id = :animal_id');
            $query->bindParam(':animal_id', $id, PDO::PARAM_INT);
            $query->execute();
            $animal = $query->fetch(PDO::FETCH_ASSOC);

            return [
                'success' => !empty($animal),
                'message' => $animal ? '' : "L'animal n'a pas été trouvé",
                'data' => $animal
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la récupération de l\'animal : ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    public function edit(int $id, array $data): array
    {
        try {
            $query = Dbutils::getPdo()->prepare('
                UPDATE animal 
                SET prenom = :prenom, etat = :etat, race = :race, image_animal = :image_animal, habitat = :habitat 
                WHERE animal_id = :animal_id
            ');
            $query->bindParam(':animal_id', $id, PDO::PARAM_INT);
            $query->bindParam(':prenom', $data['prenom']);
            $query->bindParam(':etat', $data['etat']);
            $query->bindParam(':race', $data['race']);
            $query->bindParam(':image_animal', $data['image_animal']);
            $query->bindParam(':habitat', $data['habitat']);
            $success = $query->execute();

            return [
                'success' => $success,
                'message' => $success ? 'L\'animal a été modifié' : 'Échec de la modification de l\'animal',
                'data' => $data
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la modification de l\'animal : ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    public function delete(int $id): array
    {
        try {
            $query = Dbutils::getPdo()->prepare('DELETE FROM animal WHERE animal_id = :animal_id');
            $query->bindParam(':animal_id', $id, PDO::PARAM_INT);
            $success = $query->execute();

            return [
                'success' => $success,
                'message' => $success ? 'L\'animal a été supprimé' : 'Une erreur est survenue lors de la suppression',
                'data' => null
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la suppression de l\'animal : ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    public function create(array $data): array
    {
        try {
            $query = Dbutils::getPdo()->prepare('
                INSERT INTO animal (prenom, etat, race, image_animal, habitat)
                VALUES (:prenom, :etat, :race, :image_animal, :habitat)
            ');
            $query->bindParam(':prenom', $data['prenom']);
            $query->bindParam(':etat', $data['etat']);
            $query->bindParam(':race', $data['race']);
            $query->bindParam(':image_animal', $data['image_animal']);
            $query->bindParam(':habitat', $data['habitat']);

            $success = $query->execute();

            return [
                'success' => $success,
                'message' => $success ? 'Animal ajouté avec succès' : 'Échec de l\'ajout de l\'animal',
                'data' => null
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la création de l\'animal : ' . $e->getMessage(),
                'data' => null
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
