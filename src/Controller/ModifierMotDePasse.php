<?php

namespace App\Controller;

use App\Database\Dbutils;
use PDO;

class ModifierMotDePasse
{
    public function display()
    {
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Vérifiez si tous les champs sont remplis
            if (empty($_POST['current_password']) || empty($_POST['new_password']) || empty($_POST['confirm_password'])) {
                $error = 'Tous les champs sont requis.';
            } elseif ($_POST['new_password'] !== $_POST['confirm_password']) {
                $error = 'Le nouveau mot de passe et la confirmation ne correspondent pas.';
            } else {
                $userEmail = $_SESSION['email']['email'];

                // Récupérez l'utilisateur actuel
                $query = Dbutils::getPdo()->prepare('SELECT * FROM utilisateur WHERE email = :email');
                $query->bindParam('email', $userEmail);
                $query->execute();

                $user = $query->fetch(PDO::FETCH_ASSOC);

                if (!$user || !password_verify($_POST['current_password'], $user['password'])) {
                    $error = 'Le mot de passe actuel est incorrect.';
                } else {
                    // Hachez le nouveau mot de passe et mettez-le à jour en base de données
                    $newPasswordHashed = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                    $updateQuery = Dbutils::getPdo()->prepare('UPDATE utilisateur SET password = :password WHERE email = :email');
                    $updateQuery->bindParam('password', $newPasswordHashed);
                    $updateQuery->bindParam('email', $userEmail);

                    if ($updateQuery->execute()) {
                        $success = 'Votre mot de passe a été modifié avec succès.';
                    } else {
                        $error = 'Une erreur est survenue lors de la mise à jour du mot de passe.';
                    }
                }
            }
        }

        return [
            'template' => 'modifier_mot_de_passe',
            'error' => $error,
            'success' => $success
        ];
    }
}
