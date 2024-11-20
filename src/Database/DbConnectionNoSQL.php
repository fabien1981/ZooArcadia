<?php

namespace App\Database;

use MongoDB\Client;
use Exception;

class DbConnectionNoSQL
{
    // Instance unique pour la connexion
    private static $db = null;

    /**
     * Méthode pour obtenir la connexion à MongoDB
     */
    public static function getDB()
    {
        try {
            if (self::$db !== null) {
                return self::$db;
            }

            // Charger les variables d'environnement
            $mongoUri = getenv('MONGODB_URI') ?: 'mongodb://localhost:27017';
            $databaseName = getenv('MONGODB_DATABASE') ?: 'ECFArcadia';

            // Initialisation du client MongoDB
            $client = new Client($mongoUri);

            // Sélection de la base de données
            self::$db = $client->selectDatabase($databaseName);
            return self::$db;
        } catch (Exception $e) {
           // error_log('Erreur de connexion à MongoDB : ' . $e->getMessage());
            throw new Exception('Erreur de connexion à la base de données.');
        }
    }

    /**
     * Méthode pour protéger les données avant insertion ou mise à jour
     */
    public static function protectDbData($value)
    {
        $value = trim($value);
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        return $value;
    }
}
