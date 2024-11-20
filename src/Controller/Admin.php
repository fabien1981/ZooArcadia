<?php

namespace App\Controller;

use App\Controller\CreerCompte;
use App\Database\Dbutils;
use App\Controller\Api\ConsultationController;
use PDO;
use Exception;

class Admin
{
    // Vérifie les droits d'accès Admin
    private function checkAdminAccess()
    {
        if (!isset($_SESSION['email']) || $_SESSION['email']['role'] !== 'Admin') {
            header('Location: /ZooArcadia/connexion/display');
            exit;
        }
    }

    // Affiche le tableau de bord Admin
    public function display()
    {
        $this->checkAdminAccess();

        return [
            'template' => 'admin/admin', // Chemin vers templates/admin/admin.php
            'message' => 'Tableau de bord administrateur'
        ];
    }

    // Traiter le formulaire de création de compte utilisateur
    public function creerCompte()
    {
        $this->checkAdminAccess();

        // Récupère les données du formulaire POST
        $formData = $_POST;

        $controller = new CreerCompte();
        $controller->creerCompte($formData); // Exécute la logique de création de compte

        // Redirection après la création
        $_SESSION['success_message'] = 'Le compte a été créé avec succès.';
        header('Location: /ZooArcadia/admin/display');
        exit;
    }

    public function editService(int $id): array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $image = $_POST['image']; // Nom du fichier sélectionné

                $query = Dbutils::getPdo()->prepare('UPDATE service SET nom = :nom, description = :description, image = :image WHERE service_id = :id');
                $query->bindParam(':nom', $_POST['nom']);
                $query->bindParam(':description', $_POST['description']);
                $query->bindParam(':image', $image);
                $query->bindParam(':id', $id, PDO::PARAM_INT);
                $query->execute();

                header('Location: /ZooArcadia/admin/gestion_services');
                exit;
            } catch (\Exception $e) {
                return [
                    'template' => 'error',
                    'message' => 'Erreur lors de la modification du service : ' . $e->getMessage(),
                ];
            }
        }

        // Récupération du service existant pour affichage
        $query = Dbutils::getPdo()->prepare('SELECT * FROM service WHERE service_id = :id');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $service = $query->fetch(\PDO::FETCH_ASSOC);

        // Liste des fichiers dans le dossier `photos`
        $photosDir = $_SERVER['DOCUMENT_ROOT'] . '/ZooArcadia/photos/';
        $photos = array_diff(scandir($photosDir), ['.', '..']); // Exclut `.` et `..`

        return [
            'template' => 'admin/edit_service',
            'service' => $service,
            'photos' => $photos, // Liste des photos disponibles
        ];
    }


    // Affiche le formulaire pour créer un compte utilisateur
    public function creationCompte()
    {
        $this->checkAdminAccess();

        return [
            'template' => 'admin/creation_compte', // Chemin vers templates/admin/creation_compte.php
            'message' => 'Créer un compte utilisateur'
        ];
    }

    // Affiche la page de gestion des animaux
    public function gestionAnimaux()
    {
        $this->checkAdminAccess();

        return [
            'template' => 'admin/gestion_animaux', // Chemin vers templates/admin/gestion_animaux.php
            'message' => 'Gestion des animaux'
        ];
    }
    // Méthode pour afficher la page des statistiques des consultations.

    public function displayStatsPage()
    {
        try {
            // Appel à l'API pour récupérer les statistiques
            $response = file_get_contents('http://localhost/ZooArcadia/api/consultation/statistics');
            $data = json_decode($response, true);

            if ($data['success']) {
                return [
                    'template' => 'admin/statistiques_consultations',
                    'stats' => $data['data'], // Les statistiques à afficher
                ];
            } else {
                return [
                    'template' => 'error',
                    'message' => 'Impossible de charger les statistiques.',
                ];
            }
        } catch (Exception $e) {
            return [
                'template' => 'error',
                'message' => 'Erreur : ' . $e->getMessage(),
            ];
        }
    }


    // Affiche la page des statistiques
    public function statistiquesConsultations(): array
    {
        // Récupération des données directement depuis le contrôleur API
        $consultationData = (new ConsultationController())->getStatistics();

        if ($consultationData['success']) {
            return [
                'template' => 'admin/statistiques_consultations', // Chemin vers le fichier HTML
                'stats' => $consultationData['data'], // Données pour le template
            ];
        } else {
            return [
                'template' => 'error', // Template d'erreur
                'message' => 'Impossible de charger les statistiques : ' . $consultationData['message'],
            ];
        }
    }








    // Affiche la page de gestion des horaires
    public function gestionHoraires()
    {
        $this->checkAdminAccess();

        return [
            'template' => 'admin/gestion_horaires', // Chemin vers templates/admin/gestion_horaires.php
            'message' => 'Gestion des horaires'
        ];
    }

    public function gestionServices(): array
    {
        try {
            $query = Dbutils::getPdo()->prepare('SELECT * FROM service');
            $query->execute();
            $services = $query->fetchAll(\PDO::FETCH_ASSOC);

            return [
                'template' => 'admin/gestion_services',
                'services' => $services,
            ];
        } catch (\Exception $e) {
            return [
                'template' => 'error',
                'message' => 'Erreur lors de la récupération des services : ' . $e->getMessage(),
            ];
        }
    }


    public function addService(): array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Initialisation du chemin de l'image
                $imagePath = null;

                // Vérification si une image est téléchargée
                if (!empty($_FILES['image']['name'])) {
                    // Vérification de la taille de l'image (max 2 Mo)
                    if ($_FILES['image']['size'] > 2000000) {
                        throw new \Exception('La taille de l\'image ne doit pas dépasser 2 Mo.');
                    }

                    // Vérification du type de fichier
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                        throw new \Exception('Seuls les fichiers JPEG, PNG et GIF sont autorisés.');
                    }

                    // Déplacement de l'image vers le dossier des photos
                    $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/ZooArcadia/photos/';
                    $imagePath = basename($_FILES['image']['name']);
                    $targetFile = $targetDir . $imagePath;

                    if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                        throw new \Exception('Erreur lors du téléchargement de l\'image.');
                    }
                }

                // Insertion dans la base de données
                $query = Dbutils::getPdo()->prepare(
                    'INSERT INTO service (nom, description, image) VALUES (:nom, :description, :image)'
                );
                $query->bindParam(':nom', $_POST['nom']);
                $query->bindParam(':description', $_POST['description']);
                $query->bindParam(':image', $imagePath);
                $query->execute();

                // Redirection après ajout
                header('Location: /ZooArcadia/admin/gestion_services');
                exit;
            } catch (\Exception $e) {
                return [
                    'template' => 'error',
                    'message' => 'Erreur lors de l\'ajout du service : ' . $e->getMessage(),
                ];
            }
        }
        return ['template' => 'admin/add_service'];
    }


    public function deleteService(int $id): void
    {
        try {
            $query = Dbutils::getPdo()->prepare('DELETE FROM service WHERE service_id = :id');
            $query->bindParam(':id', $id);
            $query->execute();
            header('Location: /ZooArcadia/admin/gestion_services');
            exit;
        } catch (\Exception $e) {
            header('Location: /ZooArcadia/admin/gestion_services?error=delete');
            exit;
        }
    }
}
