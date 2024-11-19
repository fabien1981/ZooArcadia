<?php
require_once '../src/Controller/Routing/DbConnectionNoSQL.php';
require_once '../src/Controller/Api/Avis.php';

use App\Controller\Api\Avis;

if (isset($_GET['id'])) {
    $avisController = new Avis();
    $response = $avisController->delete($_GET['id']);
    echo $response['message'];
} else {
    echo "Erreur : Aucun ID fourni.";
}
