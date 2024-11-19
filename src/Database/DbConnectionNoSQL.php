<?php

namespace App\Database;


use MongoDB\Client;
use Exception;


class DbConnectionNoSQL
{
  
    // Définition de l'URI pour se connecter à MongoDB
    const URI = 'mongodb+srv://julliafabien:NA3092bb@cluster0.f3axx.mongodb.net/arcadia?retryWrites=true&w=majority';
  
    // Instance unique pour la connexion
    private static $db = null;

    /*
     * Méthode pour obtenir la connexion à la base de données MongoDB
     */
    public static function getDB()
    {
        try {
            if (self::$db !== null) {
                return self::$db;
            } else {
                // Initialisation du client MongoDB
                $client = new Client(self::URI);
                // Sélection de la base de données
                self::$db = $client->selectDatabase("ECFArcadia");
                return self::$db;
            }
        } catch (Exception $e) {
            // Gestion des erreurs et redirection
            $_SESSION['message'] = 'Erreur de connexion à la base de données : ' . $e->getMessage();
            header('location: ../index.php');
            exit();
        }
    }

    /*
     * Méthode pour protéger les données avant insertion ou mise à jour
     */
    public static function protectDbData($value)
    {
        $value = htmlspecialchars($value);
        $value = strip_tags($value);
        return $value;
    }
}
