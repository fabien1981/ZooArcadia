<?php

namespace App\Controller;

use App\Database\Dbutils;

class Habitats
{
    public function display()
    {
        // Récupération des données des habitats et des animaux associés
        $pdo = Dbutils::getPdo();
        $query = $pdo->query('
            SELECT habitat.nom AS habitat_nom, 
                   animal.race, 
                   animal.prenom, 
                   animal.image_animal, 
                   animal.habitat AS habitat_id 
            FROM animal 
            INNER JOIN habitat ON animal.habitat = habitat.habitat_id
        ');

        $animauxParHabitat = [];
        while ($animal = $query->fetch(\PDO::FETCH_ASSOC)) {
            $animauxParHabitat[$animal['habitat_nom']][] = $animal;
        }

        // Descriptions des habitats
        $descriptions = [
            'Savane' => "Découvrez l'incroyable diversité de la savane africaine, un vaste écosystème où cohabitent lions majestueux, éléphants puissants et zèbres rayés. Cet habitat vous sensibilisera à la préservation de la faune et de la flore de ces paysages uniques.",
            'Jungle' => "La jungle est un monde de mystères et de biodiversité, où les bruits de la nature se mêlent aux chants des oiseaux tropicaux et aux appels des singes. Explorez cet habitat luxuriant pour découvrir la magie des forêts tropicales.",
            'Marais' => "Les marais sont des écosystèmes humides uniques, abritant une multitude d'espèces aquatiques et terrestres. Plongez dans cet environnement fascinant pour en apprendre davantage sur ces zones naturelles vitales.",
        ];

        // Préparation des données à transmettre à la vue
        return [
            'template' => 'habitats', // Nom du template (habitats.php)
            'data' => [
                'animauxParHabitat' => $animauxParHabitat,
                'descriptions' => $descriptions,
            ]
        ];
    }
}
