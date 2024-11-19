<?php

namespace App\Controller;

use App\Database\Dbutils;

class Services
{
    public function display(): array
    {
        try {
            $query = Dbutils::getPdo()->prepare('SELECT * FROM service');
            $query->execute();
            $services = $query->fetchAll(\PDO::FETCH_ASSOC);

            return [
                'template' => 'services/list',
                'services' => $services,
            ];
        } catch (\Exception $e) {
            return [
                'template' => 'error',
                'message' => 'Erreur lors de la récupération des services : ' . $e->getMessage(),
            ];
        }
    }
}
