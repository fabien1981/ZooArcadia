<?php

namespace App\Service;

use App\Entity\Animal;
use App\Database\Dbutils;
use PDO;

class AnimalService
{
    public function getAll(): array
    {
        $pdo = Dbutils::getPdo();
        $query = $pdo->query('SELECT * FROM animal');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $animals = [];
        foreach ($results as $row) {
            $animals[] = new Animal(
                $row['animal_id'],
                $row['prenom'],
                $row['race'],
                $row['etat'],
                $row['image_animal'],
                $row['habitat']
            );
        }

        return $animals;
    }

    public function getById(int $id): ?Animal
    {
        $pdo = Dbutils::getPdo();
        $query = $pdo->prepare('SELECT * FROM animal WHERE animal_id = :id');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Animal(
                $row['animal_id'],
                $row['prenom'],
                $row['race'],
                $row['etat'],
                $row['image_animal'],
                $row['habitat']
            );
        }

        return null;
    }
}
