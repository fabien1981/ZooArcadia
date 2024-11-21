<?php

namespace App\Controller;

use App\Database\Dbutils;

class NourritureController
{
    public function addNourriture()
    {
        $pdo = Dbutils::getPdo();

        // Vérification et récupération des données
        $animal_id = Dbutils::protectDbData($_POST['animal_id']);
        $date_time = Dbutils::protectDbData($_POST['date_time']);
        $type_nourriture = Dbutils::protectDbData($_POST['type_nourriture']);
        $quantite = Dbutils::protectDbData($_POST['quantite']);
        $redirect_to = $_POST['redirect_to'] ?? '/employe';

        // Vérification si l'animal existe
        $stmt = $pdo->prepare("SELECT * FROM animal WHERE animal_id = ?");
        $stmt->execute([$animal_id]);
        if (!$stmt->fetch()) {
            header("Location: /employe?status=error&message=Animal introuvable");
            exit();
        }
        // Insertion des données
        $stmt = $pdo->prepare("INSERT INTO nourriture (animal_id, date_time, type_nourriture, quantite) VALUES (:animal_id, :date_time, :type_nourriture, :quantite)");
        $stmt->execute([
            ':animal_id' => $animal_id,
            ':date_time' => $date_time,
            ':type_nourriture' => $type_nourriture,
            ':quantite' => $quantite,
        ]);

        // Redirection vers la page spécifiée
        header("Location: $redirect_to");
        exit();
    }
}
