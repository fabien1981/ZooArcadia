<?php

namespace App\Controller;

use App\Database\Dbutils;
use PDO;

class Connexion
{
    public function display()
    {
        require_once __DIR__ . '/../../config/session.php'; // S'assurer que la session est démarrée

        $error = null;
        $message = 'Se connecter';

        // Vérifie si la requête est une méthode POST (soumission du formulaire)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['email']) || empty($_POST['password'])) {
                $error = 'Veuillez renseigner tous les champs.';
            } else {
                try {
                    // Récupère l'utilisateur avec son email et joint le label de rôle
                    $query = Dbutils::getPdo()->prepare('
                        SELECT utilisateur.*, role.label AS role_label
                        FROM utilisateur
                        LEFT JOIN role ON utilisateur.role_id = role.role_id
                        WHERE email = :email
                    ');
                    $query->bindParam('email', $_POST['email']);
                    $query->execute();

                    $user = $query->fetch(PDO::FETCH_ASSOC);

                    // Vérifie l'existence de l'utilisateur et la validité du mot de passe
                    if (!$user || !password_verify($_POST['password'], $user['password'])) {
                        $error = 'Identifiants invalides.';
                    } else {
                        // Sauvegarde de l'utilisateur en session
                        unset($user['password']); // Retirer le mot de passe pour des raisons de sécurité
                        $_SESSION['email'] = [
                            'user_id' => $user['user_id'], // Assurez-vous que cette clé est incluse
                            'email' => $user['email'],
                            'role' => $user['role_label'],
                            'nom' => $user['nom'],
                            'prenom' => $user['prenom']
                        ];

                       
                        // Redirection en fonction du rôle
                        switch ($_SESSION['email']['role']) {
                            case 'Admin':
                                header('Location: admin/display');
                                break;
                            case 'Vétérinaire':
                                header('Location: veterinaire/display');
                                break;
                            case 'Employé':
                                header('Location: employe/display');
                                break;
                            default:
                                header('Location: homepage/home');
                                break;
                        }
                        exit;
                    }
                } catch (\Exception $e) {
                    $error = 'Une erreur est survenue lors de la connexion : ' . $e->getMessage();
                }
            }
        }

        // Retourne les informations nécessaires pour l'affichage du formulaire de connexion
        return [
            'template' => 'connexion',
            'error' => $error,
            'message' => $message
        ];
    }
}
