<?php

namespace App\Controller;

use App\Database\Dbutils;

class CreerCompte
{
    public function creerCompte($formulaire)
{
    require_once __DIR__ . '/../../config/session.php';

    // Vérification initiale des données du formulaire
    if (!$formulaire || empty($formulaire['email']) || empty($formulaire['password']) || empty($formulaire['nom']) || empty($formulaire['prenom']) || empty($formulaire['role'])) {
        $_SESSION['success_message'] = 'Tous les champs sont obligatoires.';
        header('Location: /ZooArcadia/admin/display');
        exit;
    }

    // Validation du mot de passe
    if (!$this->validerMotDePasse($formulaire['password'])) {
        $_SESSION['success_message'] = 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial.';
        header('Location: /ZooArcadia/admin/display');
        exit;
    }

    // Vérification de l'email déjà existant
    $pdo = Dbutils::getPdo();
    $query = $pdo->prepare('SELECT COUNT(*) FROM utilisateur WHERE email = :email');
    $query->bindParam(':email', $formulaire['email']);
    $query->execute();
    $emailExists = $query->fetchColumn();

    if ($emailExists) {
        $_SESSION['success_message'] = "L'email existe déjà.";
        header('Location: /ZooArcadia/admin/display');
        exit;
    }

    // Préparation de la requête pour insérer l'utilisateur
    $query = $pdo->prepare('INSERT INTO utilisateur (email, password, nom, prenom, role_id) VALUES (:email, :password, :nom, :prenom, :role_id)');
    $query->bindParam(':email', $formulaire['email']);
    $password = password_hash($formulaire['password'], PASSWORD_BCRYPT);
    $query->bindParam(':password', $password);
    $query->bindParam(':nom', $formulaire['nom']);
    $query->bindParam(':prenom', $formulaire['prenom']);

    // Vérification du rôle et assignation de l'ID du rôle
    $role_id = $this->getRoleId($formulaire['role']);
    if ($role_id === null) {
        $_SESSION['success_message'] = "Le rôle spécifié n'est pas valide.";
        header('Location: /ZooArcadia/admin/display');
        exit;
    }
    $query->bindParam(':role_id', $role_id);

    // Exécution de la requête d'insertion
    if ($query->execute()) {
        $_SESSION['success_message'] = 'Le compte a été créé avec succès.';
    } else {
        $_SESSION['success_message'] = 'Une erreur est survenue lors de la création du compte.';
    }

    // Redirection vers l'espace admin avec message de confirmation
    header('Location: /ZooArcadia/admin/display');
    exit;
}


    private function getRoleId($role)
    {
        // Vérification du rôle et attribution de l'ID correspondant
        if ($role === 'Vétérinaire') {
            return 2; // ID du rôle Vétérinaire
        } elseif ($role === 'Employé') {
            return 3; // ID du rôle Employé
        }
        return null; // Rôle invalide
    }

    private function validerMotDePasse($motDePasse)
    {
        return preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/', $motDePasse);
    }
}
