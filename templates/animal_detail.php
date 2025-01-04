<?php
require_once __DIR__ . '/../config/session.php';

$animal = $data['animal'] ?? null;
$lastReport = $data['lastReport'] ?? null; ?>

<div class="container mt-5">
    <h1 class="text-center">Détails de l'animal</h1>
    <?php if (!empty($animal)): ?>
        <div class="card mx-auto" style="max-width: 600px;">
            <img 
                src="photos/<?= htmlspecialchars(basename($animal['image_animal'])) ?>" 
                class="card-img-top" 
                alt="Image de <?= htmlspecialchars($animal['prenom']) ?>" 
                style="height: 300px; object-fit: cover;"
            >
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($animal['prenom']) ?></h5>
                <p class="card-text">Race : <?= htmlspecialchars($animal['race']) ?></p>
                <p class="card-text">État : <?= htmlspecialchars($animal['etat']) ?></p>
                <p class="card-text">Habitat : <?= htmlspecialchars($animal['habitat_nom']) ?></p>

                

                <h5 class="card-title">Dernier rapport vétérinaire</h5>
<?php if ($lastReport): ?>
    <p><strong>Date de la dernière visite du vétérinaire :</strong> <?= htmlspecialchars($lastReport['date']); ?></p>
    <p><strong>Avis du vétérinaire :</strong> <?= htmlspecialchars($lastReport['detail']); ?></p>
<?php else: ?>
    <p>Aucun rapport vétérinaire disponible pour cet animal.</p>
<?php endif; ?>

            </div>
        </div>





        
        <a href="habitats/display" class="btn btn-primary mt-4">
            <i class="bi bi-arrow-left"></i> Retour aux habitats
        </a>
        <?php if (!empty($habitat_id)): ?>
            <a href="habitats/show/<?= htmlspecialchars($habitat_id) ?>" class="btn btn-primary mt-4">
                <i class="bi bi-arrow-left"></i> Retour à l'habitat
            </a>
        <?php endif; ?>
    <?php else: ?>
        <p class="text-center">Aucun détail disponible pour cet animal.</p>
        <a href="habitats/display" class="btn btn-outline-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Retour aux habitats
        </a>
    <?php endif; ?>
</div>
