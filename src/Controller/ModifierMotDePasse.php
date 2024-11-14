<?php

namespace App\Controller;

use App\Database\Dbutils;
use PDO;

class ModifierMotDePasse
{
    public function afficherFormulaire()
    {
        require_once __DIR__ . '/../../config/session.php';
        $messages = ['erreur' => null, 'succes' => null];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération et filtrage des données du formulaire
            $motDePasseActuel = trim($_POST['mot_de_passe_actuel'] ?? '');
            $nouveauMotDePasse = trim($_POST['nouveau_mot_de_passe'] ?? '');
            $confirmationMotDePasse = trim($_POST['confirmation_mot_de_passe'] ?? '');

            // Validation des champs
            if (!$motDePasseActuel || !$nouveauMotDePasse || !$confirmationMotDePasse) {
                $messages['erreur'] = 'Tous les champs sont requis.';
            } elseif ($nouveauMotDePasse !== $confirmationMotDePasse) {
                $messages['erreur'] = 'Le nouveau mot de passe et la confirmation ne correspondent pas.';
            } else {
                $emailUtilisateur = $_SESSION['email']['email'] ?? null;

                if (!$emailUtilisateur) {
                    $messages['erreur'] = 'Utilisateur non identifié.';
                } else {
                    // Récupère l'utilisateur actuel
                    $pdo = Dbutils::getPdo();
                    $requete = $pdo->prepare('SELECT * FROM utilisateur WHERE email = :email');
                    $requete->bindParam(':email', $emailUtilisateur);
                    $requete->execute();

                    $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

                    if (!$utilisateur || !password_verify($motDePasseActuel, $utilisateur['password'])) {
                        $messages['erreur'] = 'Le mot de passe actuel est incorrect.';
                    } else {
                        // Hache le nouveau mot de passe et met à jour en base de données
                        $nouveauMotDePasseHache = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);
                        $miseAJour = $pdo->prepare('UPDATE utilisateur SET password = :password WHERE email = :email');
                        $miseAJour->bindParam(':password', $nouveauMotDePasseHache);
                        $miseAJour->bindParam(':email', $emailUtilisateur);

                        if ($miseAJour->execute()) {
                            $messages['succes'] = 'Votre mot de passe a été modifié avec succès.';
                        } else {
                            $messages['erreur'] = 'Une erreur est survenue lors de la mise à jour du mot de passe.';
                        }
                    }
                }
            }
        }

        // Retourne le template et les messages d'erreur ou de succès
        return [
            'template' => 'modifier_mot_de_passe',
            'erreur' => $messages['erreur'],
            'succes' => $messages['succes']
        ];
    }
}
