<?php
namespace App\Controller;

use App\Database\DbConnectionNoSQL;

class TestController
{
    public function mongodb()
    {
        try {
            // Test de connexion MongoDB
            $result = DbConnectionNoSQL::testMongoConnection();

            if (empty($result)) {
                echo '<h1>Aucune collection trouvée dans MongoDB</h1>';
            } else {
                echo '<h1>Liste des collections MongoDB :</h1>';
                echo '<ul>';
                foreach ($result as $collection) {
                    echo '<li>' . htmlspecialchars($collection) . '</li>';
                }
                echo '</ul>';
            }
        } catch (\Exception $e) {
            // Capture et affichage des erreurs
            echo '<h1>Erreur de connexion MongoDB</h1>';
            echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
            error_log('MongoDB Error: ' . $e->getMessage());
        }
    }
}
