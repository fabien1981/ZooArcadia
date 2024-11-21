<?php

namespace App\Controller;

class Logout
{
    public function logout()
    {
        // Vérifie si l'utilisateur est connecté
        if (isset($_SESSION['email'])) {
            // Supprime l'email de la session pour déconnecter l'utilisateur
            unset($_SESSION['email']);
            session_destroy(); // Détruit la session complètement
            $_SESSION = []; // Réinitialise la variable de session pour plus de sécurité
        }

        // Définit un message de succès pour l'affichage après la redirection
        $_SESSION['success_message'] = 'Vous avez été déconnecté';

        // Redirige vers la page d'accueil après la déconnexion
        header('Location: /index.php');
        exit; // Arrête le script pour s'assurer que la redirection fonctionne
    }
}
