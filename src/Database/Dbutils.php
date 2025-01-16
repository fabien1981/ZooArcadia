<?php

namespace App\Database;

use PDO;
use Exception;
use PDOException;

class Dbutils
{
    private static ?PDO $pdo = null;

    public static function getPdo(): PDO
{
    if (self::$pdo !== null) {
        return self::$pdo;
    }

    // Valeurs par défaut si les variables d'environnement ne sont pas définies
    $dsn = getenv('DB_DSN') ?: 'mysql:host=db;port=3306;dbname=zooarcadia'; // "db" correspond au service MySQL
    $user = getenv('DB_USER') ?: 'user';
    $password = getenv('DB_PASSWORD') ?: 'password';

    try {
        // Active les exceptions PDO
        self::$pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        return self::$pdo;
    } catch (PDOException $e) {
        // Journaliser l'erreur pour débogage
        error_log('Erreur de connexion MySQL : ' . $e->getMessage());
        throw new Exception('Une erreur est survenue lors de la connexion à la base de données MySQL.');
    }
}


    public static function protectDbData($value)
    {
        return htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8');
    }
}
