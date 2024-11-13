<?php

namespace App\Controller;

class Admin
{
    public function display()
    {
        // Vérifie si l'utilisateur est connecté en tant qu'Admin
        if (!isset($_SESSION['email']) || $_SESSION['email']['role'] !== 'Admin') {
            header('Location: /811/connexion/display');
            exit;
        }

        // Retourne le chemin correct pour le tableau de bord admin
        return [
            'template' => 'admin/admin', // Doit pointer vers templates/admin/admin.php
            'message' => 'Tableau de bord administrateur'
        ];
    }

    public function afficherFormulaireCreationCompte()
    {
        // Retourne le formulaire de création de compte
        return [
            'template' => 'admin/creation_compte', // Doit pointer vers templates/admin/creation_compte.php
            'message' => 'Créer un compte utilisateur'
        ];
    }

    public function ajouterAnimal()
    {
        // Vérifie si l'utilisateur est connecté en tant qu'Admin
        if (!isset($_SESSION['email']) || $_SESSION['email']['role'] !== 'Admin') {
            header('Location: /811/connexion/display');
            exit;
        }

        // Retourne le chemin correct pour le formulaire d'ajout d'animal
        return [
            'template' => 'admin/ajout_animal', // Doit pointer vers templates/admin/ajout_animal.php
            'message' => 'Ajouter un nouvel animal'
        ];
    }

    public function gestionAnimaux()
    {
        if (!isset($_SESSION['email']) || $_SESSION['email']['role'] !== 'Admin') {
            header('Location: /811/connexion/display');
            exit;
        }
    
        return [
            'template' => 'admin/gestion_animaux',
            'message' => 'Gestion des animaux'
        ];
    }
    

}
