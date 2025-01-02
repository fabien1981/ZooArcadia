<?php

namespace App\Controller;

use App\Database\Dbutils;
use PDO;
use Exception;

class Employe
{

    public function display()
{
    if (!isset($_SESSION['email']) || $_SESSION['email']['role'] !== 'Employé') {
        header('Location: /ZooArcadia/connexion/display');
        exit;
    }

    return [
        'template' => 'employe', // Chemin relatif au fichier templates/employe.php
        'message' => 'Tableau de bord employé'
    ];
}


    public function dashboard()
    {
        return [
            'template' => 'employe',
            'message' => 'Bienvenue dans votre espace employé'
        ];
    }

    // Gestion des services
    public function gestionServices(): array
    {
        try {
            $query = Dbutils::getPdo()->prepare('SELECT * FROM service');
            $query->execute();
            $services = $query->fetchAll(\PDO::FETCH_ASSOC);

            return [
                'template' => 'admin/gestion_services', // Réutilisation du template admin
                'services' => $services,
            ];
        } catch (\Exception $e) {
            return [
                'template' => 'error',
                'message' => 'Erreur lors de la récupération des services : ' . $e->getMessage(),
            ];
        }
    }

    // Modifier un service
    public function editService(int $id): array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $image = $_POST['image'];

                $query = Dbutils::getPdo()->prepare('UPDATE service SET nom = :nom, description = :description, image = :image WHERE service_id = :id');
                $query->bindParam(':nom', $_POST['nom']);
                $query->bindParam(':description', $_POST['description']);
                $query->bindParam(':image', $image);
                $query->bindParam(':id', $id, PDO::PARAM_INT);
                $query->execute();

                header('Location: /ZooArcadia/employe/gestion_services');
                exit;
            } catch (\Exception $e) {
                return [
                    'template' => 'error',
                    'message' => 'Erreur lors de la modification du service : ' . $e->getMessage(),
                ];
            }
        }

        // Récupération du service existant
        $query = Dbutils::getPdo()->prepare('SELECT * FROM service WHERE service_id = :id');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $service = $query->fetch(\PDO::FETCH_ASSOC);

        // Liste des fichiers dans le dossier `photos`
        $photosDir = $_SERVER['DOCUMENT_ROOT'] . '/ZooArcadia/photos/';
        $photos = array_diff(scandir($photosDir), ['.', '..']); 

        return [
            'template' => 'admin/edit_service', // Réutilisation du template admin
            'service' => $service,
            'photos' => $photos,
        ];
    }

    public function historiqueNourriture()
{
    $pdo = Dbutils::getPdo();

    // Récupérer l'historique de la table nourriture
    $stmt = $pdo->query("
        SELECT n.date_time, n.type_nourriture, n.quantite, a.prenom AS animal_prenom, u.nom AS user_nom, u.prenom AS user_prenom
        FROM nourriture n 
        JOIN animal a ON n.animal_id = a.animal_id
        JOIN utilisateur u ON n.user_id = u.user_id
        ORDER BY n.date_time DESC
    ");
    $nourritureData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
        'template' => 'historique_nourriture',
        'data' => [
            'nourriture' => $nourritureData, // Transmettre les données au template
        ],
        'message' => 'Historique des repas des animaux',
    ];
}



    public function alimentation()
{
    $pdo = Dbutils::getPdo();

    // Récupérer les animaux avec leurs recommandations vétérinaires non encore utilisées
    $stmt = $pdo->query("
        SELECT 
            a.animal_id, 
            a.prenom, 
            rv.nourriture AS recommandation_nourriture, 
            rv.grammage AS recommandation_grammage, 
            rv.date AS recommandation_date
        FROM animal a
        LEFT JOIN (
            SELECT animal_id, nourriture, grammage, date
            FROM rapport_veterinaire
            ORDER BY date DESC
        ) rv ON a.animal_id = rv.animal_id
        WHERE rv.animal_id IS NOT NULL
        AND NOT EXISTS (
            SELECT 1
            FROM nourriture n
            WHERE n.animal_id = a.animal_id
            AND n.date_time >= rv.date
        )
        ORDER BY a.prenom ASC
    ");
    $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
        'template' => 'employe/alimentation',
        'data' => [
            'animaux' => $animaux,
        ],
        'message' => 'Alimentation des animaux',
    ];
}

    

    


    public function nourrirAnimal(int $animalId)
{

    
    $pdo = Dbutils::getPdo();

    // Rechercher l'animal et les recommandations
    $stmt = $pdo->prepare("
        SELECT a.animal_id, a.prenom, rv.nourriture AS recommandation_nourriture, rv.grammage AS recommandation_grammage
        FROM animal a
        LEFT JOIN (
            SELECT animal_id, nourriture, grammage, date
            FROM rapport_veterinaire
            WHERE animal_id = :animal_id
            ORDER BY date DESC
            LIMIT 1
        ) rv ON a.animal_id = rv.animal_id
        WHERE a.animal_id = :animal_id
    ");
    $stmt->bindParam(':animal_id', $animalId, PDO::PARAM_INT);
    $stmt->execute();
    $animal = $stmt->fetch(PDO::FETCH_ASSOC);

  

    if (!$animal) {
        throw new Exception("Animal introuvable !");
    }

    return [
        'template' => 'nourrir',
        'data' => [
            'animal' => $animal,
        ],
        'message' => "Nourrir l'animal : " . htmlspecialchars($animal['prenom']),
    ];
}




public function addNourriture()
{

    if (empty($_POST['user_id'])) {
        throw new Exception("L'ID de l'utilisateur est manquant. Veuillez vous reconnecter.");
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
        try {
            $pdo = Dbutils::getPdo();

            // Insérer les données dans la table nourriture
            $stmt = $pdo->prepare("
                INSERT INTO nourriture (animal_id, date_time, type_nourriture, quantite, user_id)
                VALUES (:animal_id, :date_time, :type_nourriture, :quantite, :user_id)
            ");
            $stmt->bindParam(':animal_id', $_POST['animal_id'], PDO::PARAM_INT);
            $stmt->bindParam(':date_time', $_POST['date_time']);
            $stmt->bindParam(':type_nourriture', $_POST['type_nourriture']);
            $stmt->bindParam(':quantite', $_POST['quantite']);
            $stmt->bindParam(':user_id', $_POST['user_id'], PDO::PARAM_INT);
            $stmt->execute();

            // Redirection vers l'historique des repas
            header('Location: /ZooArcadia/employe/historique_nourriture');
            exit;
        } catch (\Exception $e) {
            return [
                'template' => 'error',
                'message' => 'Erreur lors de l\'ajout de la nourriture : ' . $e->getMessage(),
            ];
        }
    }

    // En cas de requête non POST
    throw new Exception('Méthode HTTP non autorisée');
}

    
}
