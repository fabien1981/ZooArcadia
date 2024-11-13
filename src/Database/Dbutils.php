<?php

namespace App\Database;
//utilisation d'un singleton pour instancier une variable une seule fois sans avoir besoin de la redéfinir
use PDO;
class Dbutils
{
    const DSN = "mysql:host=mysql-fabien31.alwaysdata.net;dbname=fabien31_arcadia";
    const USER = "fabien31_jose";
    const PASSWORD = "NA3092bb@1";

    static ?PDO $pdo = null;

    public static function getPdo(): PDO
    {
        if (self::$pdo !==null) {
            return self::$pdo;
        }
        self::$pdo = new PDO(self::DSN, self::USER, self::PASSWORD);
        return self::$pdo;
    } 
   // centralisattion des sécurités pour la protection des données
    public static function protectDbData($value){
    
        $value = htmlspecialchars($value);
        $value = strip_tags($value);

        return $value;
    }
}

