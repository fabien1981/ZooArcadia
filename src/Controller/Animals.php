<?php

namespace App\Controller;

use App\Service\AnimalService;
use App\Database\Dbutils;
use Exception;
use PDO;

class Animals
{
    private AnimalService $animalService;

    public function __construct()
    {
        $this->animalService = new AnimalService();
    }

    public function gestionAnimaux(): array
    {
        // Récupération des animaux via le service
        $animals = $this->animalService->getAll();

        // Transmettre les animaux au template
        return [
            'template' => 'admin/gestion_animaux',
            'animals' => $animals,
        ];
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
                return [
                    'template' => 'error',
                    'message' => 'Animal introuvable.'
                ];
            }

            return [
                'template' => 'animal_detail',
                'animal' => $animal,
                'habitat_id' => $animal['habitat']
            ];
        } catch (Exception $e) {
            return [
                'template' => 'error',
                'message' => 'Erreur lors de la récupération des détails : ' . $e->getMessage()
            ];
        }
    }

    public function showAnimalDetails(int $animalId)
{
    $pdo = Dbutils::getPdo();

    // Récupérer les détails de l'animal
    $stmtAnimal = $pdo->prepare("
        SELECT 
            a.animal_id, 
            a.prenom, 
            a.etat, 
            a.race, 
            a.image_animal, 
            a.habitat AS habitat_id, 
            h.nom AS habitat_nom
        FROM animal a
        LEFT JOIN habitat h ON a.habitat = h.habitat_id
        WHERE a.animal_id = :animal_id
    ");
    $stmtAnimal->bindParam(':animal_id', $animalId, PDO::PARAM_INT);
    $stmtAnimal->execute();
    $animal = $stmtAnimal->fetch(PDO::FETCH_ASSOC);

    if (!$animal) {
        return [
            'template' => 'animal_detail',
            'data' => [
                'animal' => null,
                'lastReport' => null
            ],
            'message' => 'Animal introuvable'
        ];
    }

    // Récupérer le dernier rapport vétérinaire
    $stmtReport = $pdo->prepare("
        SELECT 
            rv.date, 
            rv.detail
        FROM rapport_veterinaire rv
        WHERE rv.animal_id = :animal_id
        ORDER BY rv.date DESC
        LIMIT 1
    ");
    $stmtReport->bindParam(':animal_id', $animalId, PDO::PARAM_INT);
    $stmtReport->execute();
    $lastReport = $stmtReport->fetch(PDO::FETCH_ASSOC);

  
    return [
        'template' => 'animal_detail',
        'data' => [
            'animal' => $animal,
            'lastReport' => $lastReport ?: null // Null si aucun rapport trouvé
        ],
        'message' => 'Détails de l\'animal'
    ];
}





}
