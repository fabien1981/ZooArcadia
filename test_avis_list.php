<?php
// Simulation des données
$avis = [
    ['pseudo' => 'Test User', 'avis' => 'Ceci est un test', 'rating' => 4],
    ['pseudo' => 'Autre User', 'avis' => 'Avis de test', 'rating' => 5],
];

// Chemin vers le fichier avis_list.php
$page = 'templates/avis_list.php';

// Vérification que le fichier existe
if (!file_exists($page)) {
    error_log("Le fichier $page est introuvable.");
    echo "Le fichier de template est introuvable.";
    return;
}

// Définition de la variable `$page` pour base_template.php
$page = $page;

// Inclure le fichier base_template.php
include 'templates/base_template.php';
