<?php

namespace App\Database;

use MongoDB\Client;
use Exception;

class DbConnectionNoSQL
{
   
    private static $db = null;

    /**
     * Méthode pour obtenir la connexion à MongoDB avec des valeurs codées en dur
     */
    public static function getDB()
    {
        try {
            if (self::$db !== null) {
                return self::$db;
            }

            // URI et nom de la base codés en dur
            $mongoUri = 'mongodb+srv://julliafabien:NA3092bb@cluster0.f3axx.mongodb.net/arcadia?retryWrites=true&w=majority';
            $databaseName = 'ECFArcadia';

          
            // Initialisation du client MongoDB
            $client = new Client($mongoUri);
            self::$db = $client->selectDatabase($databaseName);

            return self::$db;
        } catch (Exception $e) {
            throw new Exception('Erreur de connexion à la base de données : ' . $e->getMessage());
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
