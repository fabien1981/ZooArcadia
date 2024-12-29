<div class="container mt-5">
    <h1 class="text-center">Détails de l'animal</h1>
    <?php if (!empty($animal)): ?>
        <div class="card mx-auto" style="max-width: 600px;">
            <img 
                src="/ZooArcadia/photos/<?= htmlspecialchars(basename($animal->getImage())) ?>" 
                class="card-img-top" 
                alt="Image de <?= htmlspecialchars($animal->getPrenom()) ?>" 
                style="height: 300px; object-fit: cover;"
            >
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($animal->getPrenom()) ?></h5>
                <p class="card-text">Race : <?= htmlspecialchars($animal->getRace()) ?></p>
                <p class="card-text">État : <?= htmlspecialchars($animal->getEtat()) ?></p>
                <p class="card-text">Habitat : <?= htmlspecialchars($animal->getHabitatId()) ?></p>
            </div>
        </div>
        <a href="/ZooArcadia/habitats/display" class="btn btn-primary mt-4">
            <i class="bi bi-arrow-left"></i> Retour aux habitats
        </a>
        <?php if (isset($habitat_id)): ?>
            <a href="/ZooArcadia/habitats/show/<?= htmlspecialchars($habitat_id) ?>" class="btn btn-primary mt-4">
                <i class="bi bi-arrow-left"></i> Retour à l'habitat
            </a>
        <?php endif; ?>
    <?php else: ?>
        <p class="text-center">Aucun détail disponible pour cet animal.</p>
        <a href="/ZooArcadia/habitats/display" class="btn btn-outline-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Retour aux habitats
        </a>
    <?php endif; ?>
</div>


