<?php
namespace App\Controller;

class Test
{
    public function mongodb()
    {
        // Nettoyer les tampons de sortie
        if (ob_get_length()) {
            ob_clean();
        }

        // Définir les en-têtes pour une réponse JSON
        header('Content-Type: application/json; charset=utf-8');

        // Retourner une réponse JSON
        echo json_encode([
            'message' => 'Test MongoDB executed successfully!',
            'status' => 'success'
        ]);

        // Terminer le script
        exit();
    }
}
