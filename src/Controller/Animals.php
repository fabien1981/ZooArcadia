<?php

namespace App\Controller;

use App\Service\AnimalService;

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
}
