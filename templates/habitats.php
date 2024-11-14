
<?php

use App\Database\Dbutils;

$query = Dbutils::getPdo()->query('SELECT habitat.nom AS habitat_nom, animal.race, animal.prenom, animal.image_animal, animal.habitat AS habitat_id 
                                    FROM animal 
                                    INNER JOIN habitat ON animal.habitat = habitat.habitat_id');

$animauxParHabitat = [];
while ($animal = $query->fetch(PDO::FETCH_ASSOC)) {
    $animauxParHabitat[$animal['habitat_nom']][] = $animal;
}

// Descriptions des habitats
$descriptions = [
    'Savane' => "Découvrez l'incroyable diversité de la savane africaine, un vaste écosystème où cohabitent lions majestueux, éléphants puissants et zèbres rayés. Cet habitat vous sensibilisera à la préservation de la faune et de la flore de ces paysages uniques.",
    'Jungle' => "La jungle est un monde de mystères et de biodiversité, où les bruits de la nature se mêlent aux chants des oiseaux tropicaux et aux appels des singes. Explorez cet habitat luxuriant pour découvrir la magie des forêts tropicales.",
    'Marais' => "Les marais sont des écosystèmes humides uniques, abritant une multitude d'espèces aquatiques et terrestres. Plongez dans cet environnement fascinant pour en apprendre davantage sur ces zones naturelles vitales.",
];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Zoo Arcadia - Nos Habitats</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
    <style>
        .habitat-card {
            cursor: pointer;
            transition: transform 0.3s;
        }
        .habitat-card:hover {
            transform: scale(1.05);
        }
        .habitat-details {
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center mt-5">Nos Habitats</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
        <?php foreach ($animauxParHabitat as $habitat => $animaux): ?>
            <div class="col">
                <div class="card habitat-card" onclick="toggleDetails('<?php echo $habitat; ?>')">
                    <img src="../assets/photos/<?php echo strtolower($habitat); ?>.jpeg" class="card-img-top" alt="<?php echo $habitat; ?>">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $habitat; ?></h5>
                    </div>
                </div>

                <!-- Détails de l'habitat affichés au clic -->
                <div class="habitat-details mt-3" id="details-<?php echo $habitat; ?>">
                    <p><?php echo $descriptions[$habitat]; ?></p>
                    <h6>Animaux présents :</h6>
                    <ul>
                        <?php foreach ($animaux as $animal): ?>
                            <li><?php echo $animal['race']; ?> - Prénom : <?php echo $animal['prenom']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    // Fonction pour afficher/masquer les détails de l'habitat au clic
    function toggleDetails(habitat) {
        const detailsDiv = document.getElementById('details-' + habitat);
        const isVisible = detailsDiv.style.display === 'block';
        document.querySelectorAll('.habitat-details').forEach(div => div.style.display = 'none');
        detailsDiv.style.display = isVisible ? 'none' : 'block';
    }
</script>

</body>
</html>
