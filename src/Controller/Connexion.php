<?php

namespace App\Controller;

use App\Database\Dbutils;
use PDO;

class Connexion
{
    public function display()
    {
        $error = null;
        $message = 'Se connecter';

        // Vérifie si la requête est une méthode POST (soumission du formulaire)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

                if (!$user || !password_verify($_POST['password'], $user['password'])) {
                    $error = 'Identifiants invalides';
                } else {
                    // Sauvegarde de l'utilisateur en session, avec le label de rôle
                    unset($user['password']);
                    $_SESSION['email'] = [
                        'email' => $user['email'],
                        'role' => $user['role_label'],  // Stocke le label du rôle
                        'nom' => $user['nom'],
                        'prenom' => $user['prenom']
                    ];

                   // Redirection en fonction du rôle
                   switch ($_SESSION['email']['role']) {
                    case 'Admin':
                        header('Location: /811/admin/display');
                        break;
                    case 'Vétérinaire':
                        header('Location: /811/veterinaire/display');
                        break;
                    case 'Employé':
                        header('Location: /811/employe/display');
                        break;
                    default:
                        header('Location: /811/homepage/home');
                        break;
                }
                exit;
                }
            }
        }

        return [
            'template' => 'connexion',
            'error' => $error,
            'message' => $message
        ];
    }
}
