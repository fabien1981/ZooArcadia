<?php

namespace App\Controller;

class Veterinaire
{
    public function display()
    {
        if (!isset($_SESSION['email']) || $_SESSION['email']['role'] !== 'Vétérinaire') {
            header('Location: /811/connexion/display');
            exit;
        }
        // Logique pour afficher la page des habitats
        return [
            'template' => 'veterinaire', // ou autre nom selon votre template
            'message' => 'Espace vétérinaire'
        ];
    }
}