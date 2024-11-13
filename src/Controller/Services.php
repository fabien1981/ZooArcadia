<?php

namespace App\Controller;

class Services
{
    public function display()
    {
        // Logique pour afficher la page des habitats
        return [
            'template' => 'services', // ou autre nom selon votre template
            'message' => 'Bienvenue dans nos services'
        ];
    }
}