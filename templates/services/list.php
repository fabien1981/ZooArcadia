<div class="container mt-5">
    <h1 class="text-center">Nos Services</h1>

    <?php if (!empty($services)): ?>
        <div class="row mt-4">
            <?php foreach ($services as $service): ?>
                <?php 
                    // Gestion de l'image de service
                    $imagePath = "/photos/" . htmlspecialchars($service['image'] ?? '');
                    $defaultImagePath = "/photos/default_service.jpg"; // Image par défaut
                    $fullImagePath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;

                    // Vérifie si l'image existe
                    if (empty($service['image']) || !file_exists($fullImagePath)) {
                        $imagePath = $defaultImagePath;
                    }
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img 
                            src="<?= htmlspecialchars($imagePath) ?>" 
                            class="card-img-top" 
                            alt="<?= htmlspecialchars($service['nom']) ?>" 
                            style="height: 400px; object-fit: cover; width: 100%; border-radius: 5px;"
                        >
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($service['nom']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($service['description'] ?? 'Pas de description disponible.') ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center">Aucun service n'est actuellement disponible.</p>
    <?php endif; ?>
</div>
