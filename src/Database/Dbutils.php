<?php

namespace App\Database;

use PDO;

class Dbutils
{
    private static ?PDO $pdo = null;

    public static function getPdo(): PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        // Charger les variables d'environnement directement depuis getenv()
        $dsn = getenv('DB_DSN');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');

        // Active les exceptions PDO
        self::$pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        return self::$pdo;
    }

    public static function protectDbData($value)
    {
        return htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8');
    }
}
