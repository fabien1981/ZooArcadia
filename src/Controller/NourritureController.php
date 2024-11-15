<?php

namespace App\Controller;

use App\Database\Dbutils;

class NourritureController
{
    public function addNourriture()
    {
        // Connexion à la base de données via Dbutils
        $pdo = Dbutils::getPdo();

        // Récupération des données du formulaire avec une protection supplémentaire
        $animal_id = Dbutils::protectDbData($_POST['animal_id']);
        $date_time = Dbutils::protectDbData($_POST['date_time']);
        $type_nourriture = Dbutils::protectDbData($_POST['type_nourriture']);
        $quantite = Dbutils::protectDbData($_POST['quantite']);

        // Préparation de la requête SQL
        $stmt = $pdo->prepare("INSERT INTO nourriture (animal_id, date_time, type_nourriture, quantite) VALUES (:animal_id, :date_time, :type_nourriture, :quantite)");

        // Exécution de la requête
        $stmt->execute([
            ':animal_id' => $animal_id,
            ':date_time' => $date_time,
            ':type_nourriture' => $type_nourriture,
            ':quantite' => $quantite,
        ]);

        // Redirection avec message de confirmation
        header("Location: /employe.php?status=success");
        exit();
    }
}
