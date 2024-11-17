<div class="container mt-5">
    <h1 class="text-center">Détails de l'habitat</h1>
    <?php if (!empty($habitat)): ?>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($habitat['nom']) ?></h5>
                <p class="card-text">Description : <?= htmlspecialchars($habitat['description'] ?? 'Aucune description disponible') ?></p>
                <p class="card-text">Autres détails : <?= htmlspecialchars($habitat['commentaire_habitat'] ?? 'Non spécifié') ?></p>
            </div>
        </div>

        <div class="mt-4">
            <h2>Animaux présents dans cet habitat :</h2>
            <?php if (!empty($animaux)): ?>
                <div class="row">
                    <?php foreach ($animaux as $animal): ?>
                        <?php
                            // Récupération des informations de l'animal depuis la base de données
                            $pdo = \App\Database\Dbutils::getPdo();
                            $stmt = $pdo->prepare('SELECT image_animal FROM animal WHERE animal_id = :id');
                            $stmt->bindParam(':id', $animal['animal_id'], PDO::PARAM_INT);
                            $stmt->execute();
                            $animalData = $stmt->fetch(PDO::FETCH_ASSOC);

                            // Déterminer le chemin de l'image
                            $imagePath = "/ZooArcadia/photos/" . htmlspecialchars(basename($animalData['image_animal'] ?? ''));
                            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath) || empty($animalData['image_animal'])) {
                                $imagePath = "/ZooArcadia/photos/default_animal.jpg"; // Image par défaut si le fichier n'existe pas
                            }
                        ?>
                        <div class="col-md-4 mb-4">
                            <a href="/ZooArcadia/animals/show/<?= htmlspecialchars($animal['animal_id']) ?>?habitat_id=<?= htmlspecialchars($habitat['habitat_id']) ?>" style="text-decoration: none; color: inherit;">
                                <div class="card">
                                    <img 
                                        src="<?= $imagePath ?>" 
                                        class="card-img-top" 
                                        alt="Image de <?= htmlspecialchars($animal['prenom']) ?>" 
                                        style="height: 200px; object-fit: cover;"
                                    >
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($animal['prenom']) ?></h5>
                                        <p class="card-text">
                                            Race : <?= htmlspecialchars($animal['race'] ?? 'Non spécifié') ?><br>
                                            État : <?= htmlspecialchars($animal['etat'] ?? 'Non spécifié') ?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Aucun animal n'est actuellement répertorié dans cet habitat.</p>
            <?php endif; ?>
        </div>

        <!-- Bouton Retour aux habitats -->
        <a href="/ZooArcadia/habitats/display" class="btn btn-primary mt-4">
            <i class="bi bi-arrow-left"></i> Retour aux habitats
        </a>
    <?php else: ?>
        <p class="text-center">Aucun détail disponible pour cet habitat.</p>
        <!-- Bouton Retour aux habitats même si l'habitat est introuvable -->
        <a href="/ZooArcadia/habitats/display" class="btn btn-outline-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Retour aux habitats
        </a>
    <?php endif; ?>
</div>
