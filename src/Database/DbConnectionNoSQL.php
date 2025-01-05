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
            return self::$db;
        }

        // Récupérer les paramètres de connexion depuis les variables d'environnement
        $mongoUri = getenv('MONGODB_URI') ?: 'mongodb://localhost:27017';
        $databaseName = getenv('MONGODB_DATABASE') ?: 'default_database';

        try {
            // Créer une connexion MongoDB
            $client = new Client($mongoUri);
            self::$db = $client->selectDatabase($databaseName);
            return self::$db;
        } catch (Exception $e) {
            // Journaliser l'erreur pour débogage
            error_log('Erreur de connexion MongoDB : ' . $e->getMessage());
            // Lancer une exception générique pour l'utilisateur
            throw new Exception('Une erreur est survenue lors de la connexion à la base de données.');
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
