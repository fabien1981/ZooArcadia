<?php

namespace App\Controller;
use App\Database\Dbutils;
use PDO;
class Homepage
{
    public function home()
    {
        $query = Dbutils::getPdo()->query('SELECT * FROM animal');
        $animaux = $query->fetchAll(PDO::FETCH_ASSOC);
        return [
            'template' => 'home/homepage', 
            'data' => ['animaux' => $animaux],
        ];
    }
}