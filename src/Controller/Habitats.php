<?php

namespace App\Controller;

class Habitats
{
    public function display()
    {
        // Logique pour afficher la page des habitats
        return [
            'template' => 'habitats', // ou autre nom selon votre template
            'message' => 'Bienvenue dans la page des habitats'
        ];
    }
}
