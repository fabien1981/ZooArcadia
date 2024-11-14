<?php

namespace App\Controller;

use App\Controller\CreerCompte;

class Admin
{
    // Vérifie les droits d'accès Admin
    private function checkAdminAccess()
    {
        if (!isset($_SESSION['email']) || $_SESSION['email']['role'] !== 'Admin') {
            header('Location: /ZooArcadia/connexion/display');
            exit;
        }
    }

    // Affiche le tableau de bord Admin
    public function display()
    {
        $this->checkAdminAccess();

        return [
            'template' => 'admin/admin', // Chemin vers templates/admin/admin.php
            'message' => 'Tableau de bord administrateur'
        ];
    }

    // Créer un compte utilisateur
    public function creerCompte($formData)
    {
        $this->checkAdminAccess();
        
        $controller = new CreerCompte();
        return $controller->creerCompte($formData);
    }

    // Affiche le formulaire pour créer un compte utilisateur
    public function afficherFormulaireCreationCompte()
    {
        $this->checkAdminAccess();

        return [
            'template' => 'admin/creation_compte', // Chemin vers templates/admin/creation_compte.php
            'message' => 'Créer un compte utilisateur'
        ];
    }

    // Affiche le formulaire pour ajouter un animal
    public function ajouterAnimal()
    {
        $this->checkAdminAccess();

        return [
            'template' => 'admin/ajout_animal', // Chemin vers templates/admin/ajout_animal.php
            'message' => 'Ajouter un nouvel animal'
        ];
    }

    // Affiche la page de gestion des animaux
    public function gestionAnimaux()
    {
        $this->checkAdminAccess();

        return [
            'template' => 'admin/gestion_animaux', // Chemin vers templates/admin/gestion_animaux.php
            'message' => 'Gestion des animaux'
        ];
    }

    // Affiche la page de gestion des horaires
    public function gestionHoraires()
    {
        $this->checkAdminAccess();

        return [
            'template' => 'admin/gestion_horaires', // Chemin vers templates/admin/gestion_horaires.php
            'message' => 'Gestion des horaires'
        ];
    }
}
