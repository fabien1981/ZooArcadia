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
                $error = 'Identifiants invalides';
            } else {
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
                    $error = 'Identifiants invalides';
                } else {
                    // Sauvegarde de l'utilisateur en session
                    unset($user['password']);
                    $_SESSION['email'] = [
                        'email' => $user['email'],
                        'role' => $user['role_label'],
                        'nom' => $user['nom'],
                        'prenom' => $user['prenom']
                    ];

                    // Redirection en fonction du rôle
                    switch ($_SESSION['email']['role']) {
                        case 'Admin':
                            header('Location: /ZooArcadia/admin/display');
                            break;
                        case 'Vétérinaire':
                            header('Location: /ZooArcadia/veterinaire/display');
                            break;
                        case 'Employé':
                            header('Location: /ZooArcadia/employe/display');
                            break;
                        default:
                            header('Location: /ZooArcadia/homepage/home');
                            break;
                    }
                    exit;
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
