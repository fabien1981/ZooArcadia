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

        $mongoUri = getenv('MONGODB_URI') ?: 'mongodb://localhost:27017';
        $databaseName = getenv('MONGODB_DATABASE') ?: 'ECFArcadia';

        try {
            $client = new Client($mongoUri);
            self::$db = $client->selectDatabase($databaseName);
            return self::$db;
        } catch (Exception $e) {
            throw new Exception('Erreur de connexion MongoDB : ' . $e->getMessage());
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

    public static function testConnection()
{
    try {
        $db = self::getDB();
        return $db->listCollections(); // Liste toutes les collections
    } catch (Exception $e) {
        return 'Erreur : ' . $e->getMessage();
    }
}

public static function testMongoConnection()
    {
        try {
            $db = self::getDB();
            $collections = $db->listCollections();

            $result = [];
            foreach ($collections as $collection) {
                $result[] = $collection->getName();
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception('Erreur MongoDB : ' . $e->getMessage());
        }
    }


}
