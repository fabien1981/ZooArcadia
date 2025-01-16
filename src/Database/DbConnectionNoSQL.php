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
        if (self::$db !== null) {
            error_log("Connexion MongoDB déjà établie.");
            return self::$db;
        }
    
        $mongoUri = getenv('MONGODB_URI') ?: 'mongodb://mongodb:27017';
        $databaseName = getenv('MONGODB_DATABASE') ?: 'ECFArcadia';
    
        try {
            $client = new \MongoDB\Client($mongoUri);
            self::$db = $client->selectDatabase($databaseName);
            error_log("Connexion réussie à MongoDB : $mongoUri, base de données : $databaseName");
            return self::$db;
        } catch (\Exception $e) {
            error_log("Erreur de connexion MongoDB : " . $e->getMessage());
            throw new \Exception('Erreur de connexion MongoDB.');
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
