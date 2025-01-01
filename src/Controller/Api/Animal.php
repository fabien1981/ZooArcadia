<?php

namespace App\Controller\Api;

use App\Database\Dbutils;
use PDO;
use Exception;

/**
 * Class Animal
 * Contrôleur API pour gérer les opérations CRUD sur les animaux.
 */
class Animal
{
    /**
     * Récupère la liste complète des animaux avec leurs habitats associés.
     *
     * @return array Un tableau contenant la réussite et les données ou un message d'erreur.
     */
    public function list(): array
    {
        try {
            // Préparation de la requête pour récupérer les animaux avec leurs habitats
            $query = Dbutils::getPdo()->prepare('
                SELECT animal.*, habitat.nom AS habitat_nom
                FROM animal
                JOIN habitat ON animal.habitat = habitat.habitat_id
            ');
            $query->execute();
            $animaux = $query->fetchAll(PDO::FETCH_ASSOC);

            // Vérifie si des animaux ont été trouvés
            if (!$animaux) {
                return [
                    'success' => true,
                    'data' => [],
                    'message' => 'Aucun animal trouvé.'
                ];
            }

            // Retourne les données récupérées
            return [
                'success' => true,
                'data' => $animaux
            ];
        } catch (Exception $e) {
            // Gestion des erreurs
            return [
                'success' => false,
                'message' => 'Erreur lors de la récupération des animaux : ' . $e->getMessage()
            ];
        }
    }

    /**
     * Supprime un animal par son ID.
     *
     * @param int $id L'ID de l'animal à supprimer.
     * @return array Un tableau contenant la réussite ou un message d'erreur.
     */
    public function delete(int $id): array
    {
        try {
            // Vérifie si l'animal existe
            $query = Dbutils::getPdo()->prepare('SELECT * FROM animal WHERE animal_id = :id');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            if (!$query->fetch()) {
                return ['success' => false, 'message' => 'Animal introuvable.'];
            }

            // Supprime l'animal
            $query = Dbutils::getPdo()->prepare('DELETE FROM animal WHERE animal_id = :id');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            return ['success' => true, 'message' => 'Animal supprimé avec succès.'];
        } catch (Exception $e) {
            // Gestion des erreurs
            return ['success' => false, 'message' => 'Erreur lors de la suppression : ' . $e->getMessage()];
        }
    }

    /**
     * Récupère la liste des habitats disponibles.
     *
     * @return array Un tableau contenant la réussite, les données des habitats ou un message d'erreur.
     */
    public function getHabitats(): array
    {
        try {
            // Récupère tous les habitats
            $query = Dbutils::getPdo()->prepare('SELECT * FROM habitat');
            $query->execute();
            $habitats = $query->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'data' => $habitats,
                'message' => $habitats ? '' : 'Aucun habitat disponible.'
            ];
        } catch (Exception $e) {
            // Gestion des erreurs
            return [
                'success' => false,
                'message' => 'Erreur lors de la récupération des habitats : ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Ajoute un nouvel animal à la base de données.
     *
     * @param array $data Les données de l'animal à ajouter.
     * @return array Un tableau contenant la réussite ou un message d'erreur.
     */
    public function create(array $data): array
    {
        // Validation des données requises
        if (empty($data['prenom']) || empty($data['race']) || empty($data['etat']) || empty($data['habitat'])) {
            return ['success' => false, 'message' => 'Tous les champs sont requis.'];
        }

        try {
            // Insertion des données dans la base
            $query = Dbutils::getPdo()->prepare('
                INSERT INTO animal (prenom, race, etat, image_animal, habitat) 
                VALUES (:prenom, :race, :etat, :image_animal, :habitat)
            ');
            $query->bindParam(':prenom', $data['prenom']);
            $query->bindParam(':race', $data['race']);
            $query->bindParam(':etat', $data['etat']);
            $query->bindParam(':image_animal', $data['image_animal']);
            $query->bindParam(':habitat', $data['habitat']);
            $query->execute();

            return ['success' => true, 'message' => 'Animal ajouté avec succès.'];
        } catch (Exception $e) {
            // Gestion des erreurs
            return ['success' => false, 'message' => 'Erreur lors de l\'ajout de l\'animal : ' . $e->getMessage()];
        }
    }

    /**
     * Met à jour les informations d'un animal existant.
     *
     * @param int $id L'ID de l'animal à mettre à jour.
     * @param array $data Les nouvelles données de l'animal.
     * @return array Un tableau contenant la réussite ou un message d'erreur.
     */
    public function edit(int $id, array $data): array
    {
        // Validation des données requises
        if (empty($data['prenom']) || empty($data['race']) || empty($data['etat']) || empty($data['habitat'])) {
            return ['success' => false, 'message' => 'Tous les champs sont requis.'];
        }

        try {
            // Vérifie si l'animal existe
            $query = Dbutils::getPdo()->prepare('SELECT * FROM animal WHERE animal_id = :id');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            if (!$query->fetch()) {
                return ['success' => false, 'message' => 'Animal introuvable.'];
            }

            // Met à jour les informations de l'animal
            $query = Dbutils::getPdo()->prepare('
                UPDATE animal 
                SET prenom = :prenom, race = :race, etat = :etat, image_animal = :image_animal, habitat = :habitat
                WHERE animal_id = :id
            ');
            $query->bindParam(':prenom', $data['prenom']);
            $query->bindParam(':race', $data['race']);
            $query->bindParam(':etat', $data['etat']);
            $query->bindParam(':image_animal', $data['image_animal']);
            $query->bindParam(':habitat', $data['habitat']);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            return ['success' => true, 'message' => 'Animal mis à jour avec succès.'];
        } catch (Exception $e) {
            // Gestion des erreurs
            return ['success' => false, 'message' => 'Erreur lors de la mise à jour : ' . $e->getMessage()];
        }
    }

    /**
     * Récupère les détails d'un animal par son ID.
     *
     * @param int $id L'ID de l'animal.
     * @return array Un tableau contenant les détails de l'animal ou un message d'erreur.
     */
    public function show(int $id): array
    {
        try {
            // Récupère les détails de l'animal
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
            return ['success' => false, 'message' => 'Erreur lors de la récupération des détails : ' . $e->getMessage()];
        }
    }

    

}
