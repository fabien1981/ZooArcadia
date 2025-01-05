<?php

namespace App\Controller;

use App\Database\DbConnectionNoSQL;

class TestController
{
    public function testMongoDB()
    {
        try {
            $result = DbConnectionNoSQL::testMongoConnection();
            echo '<pre>';
            print_r($result);
            echo '</pre>';
        } catch (\Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }
}
