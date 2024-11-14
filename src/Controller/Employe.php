<?php

namespace App\Controller;

class Employe
{
    public function display()
    {
        if (!isset($_SESSION['email']) || $_SESSION['email']['role'] !== 'Employé') {
            header('Location: /ZooArcadia/connexion/display');
            exit;
        }
        // Logique pour afficher la page des habitats
        return [
            'template' => 'employe', // ou autre nom selon votre template
            'message' => 'Espace employé'
        ];
    }
}