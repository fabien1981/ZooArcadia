<?php

namespace App\Controller;

use App\Database\Dbutils;
use PDO;

class Employe
{
    public function display()
    {
        return [
            'template' => 'employe',
        ];
    }

    public function nourrir()
{
    $animal_id = $_GET['animal_id'] ?? null;

    if (!$animal_id) {
        return [
            'template' => 'error',
            'data' => ['message' => 'Aucun animal spécifié.']
        ];
    }

    $animalApi = new \App\Controller\Api\Animal();
    $result = $animalApi->show($animal_id);

    if (!$result['success']) {
        return [
            'template' => 'error',
            'data' => ['message' => $result['message']]
        ];
    }

    return [
        'template' => 'nourrir',
        'data' => ['animal' => $result['data']]
    ];
}

    
}
