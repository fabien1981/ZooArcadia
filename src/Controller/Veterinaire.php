<?php

namespace App\Controller;

use App\Database\Dbutils;
use PDO;
use Exception;

class Veterinaire
{
    public function display()
    {
        if (!isset($_SESSION['email']) || $_SESSION['email']['role'] !== 'Vétérinaire') {
            header('Location: /connexion/display');
            exit;
        }

        return [
            'template' => 'veterinaire',
            'message' => 'Espace vétérinaire'
        ];
    }

    public function createReport()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Si appel via formulaire classique
        $animalId = $_POST['animal_id'] ?? null;
        $etat = $_POST['etat'] ?? null;
        $nourriture = $_POST['nourriture'] ?? null;
        $grammage = $_POST['grammage'] ?? null;
        $detail = $_POST['detail'] ?? null;

        if (!$animalId || !$etat || !$nourriture || !$grammage || !$detail) {
            $_SESSION['error_message'] = 'Tous les champs sont requis.';
            header('Location: /veterinaire/createReport?animal_id=' . $animalId);
            exit;
        }

        try {
            $pdo = Dbutils::getPdo();

            // Insérer un nouveau rapport
            $stmt = $pdo->prepare(
                'INSERT INTO rapport_veterinaire (animal_id, date, etat, nourriture, grammage, detail) 
                 VALUES (:animal_id, NOW(), :etat, :nourriture, :grammage, :detail)'
            );
            $stmt->bindParam(':animal_id', $animalId, PDO::PARAM_INT);
            $stmt->bindParam(':etat', $etat);
            $stmt->bindParam(':nourriture', $nourriture);
            $stmt->bindParam(':grammage', $grammage);
            $stmt->bindParam(':detail', $detail);
            $stmt->execute();

            // Mettre à jour l'état de l'animal
            $updateStmt = $pdo->prepare('UPDATE animal SET etat = :etat WHERE animal_id = :animal_id');
            $updateStmt->bindParam(':etat', $etat);
            $updateStmt->bindParam(':animal_id', $animalId, PDO::PARAM_INT);
            $updateStmt->execute();

            $_SESSION['success_message'] = 'Rapport créé avec succès et état de l\'animal mis à jour.';
            header('Location: /veterinaire/display');
            exit;
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
            header('Location: /veterinaire/createReport?animal_id=' . $animalId);
            exit;
        }
    }

    // Gérer les requêtes GET pour afficher le formulaire
    $animalId = $_GET['animal_id'] ?? null;
    if (!$animalId) {
        $_SESSION['error_message'] = 'ID de l\'animal manquant.';
        header('Location: /veterinaire/display');
        exit;
    }

    $pdo = Dbutils::getPdo();
    $stmt = $pdo->prepare('SELECT * FROM animal WHERE animal_id = :id');
    $stmt->bindParam(':id', $animalId, PDO::PARAM_INT);
    $stmt->execute();
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$animal) {
        $_SESSION['error_message'] = 'Animal introuvable.';
        header('Location: /veterinaire/display');
        exit;
    }

    return [
        'template' => 'creation_rapport',
        'data' => ['animal' => $animal],
        'message' => 'Créer un rapport vétérinaire'
    ];
}






public function reports()
{
    try {
        $pdo = Dbutils::getPdo();
        $stmt = $pdo->prepare("
            SELECT rv.rapport_veterinaire_id, rv.date, rv.etat, rv.nourriture, rv.grammage, rv.detail, a.prenom 
            FROM rapport_veterinaire rv
            JOIN animal a ON rv.animal_id = a.animal_id
        ");
        $stmt->execute();
        $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'success' => true,
            'data' => $reports
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Erreur lors de la récupération des rapports vétérinaires : ' . $e->getMessage()
        ];
    }
}

public function apiReports()
{
    try {
        $pdo = Dbutils::getPdo();
        $stmt = $pdo->prepare("
            SELECT rv.rapport_veterinaire_id, rv.date, rv.etat, rv.nourriture, rv.grammage, rv.detail, a.prenom 
            FROM rapport_veterinaire rv
            JOIN animal a ON rv.animal_id = a.animal_id
        ");
        $stmt->execute();
        $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'data' => $reports]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération des rapports vétérinaires : ' . $e->getMessage()]);
    }
    exit;
}



    public function showReports()
{
    if (!isset($_SESSION['email']) || $_SESSION['email']['role'] !== 'Vétérinaire') {
        header('Location: /connexion/display');
        exit;
    }

    return [
        'template' => 'rapports_veterinaires',
        'message' => 'Liste des rapports vétérinaires'
    ];
}


}
