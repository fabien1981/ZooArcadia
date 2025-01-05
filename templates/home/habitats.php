<div class="container mt-5">
    <!-- Bloc descriptif au-dessus du carrousel -->
    <div class="row align-items-center mb-5">
        <!-- Image à gauche -->
        <div class="col-md-4 text-center">
            <img src="/ZooArcadia/photos/ZooArcadia.jpeg" alt="Description du Zoo" class="img-fluid rounded shadow-sm">
        </div>
        <!-- Texte descriptif à droite -->
        <div class="col-md-8">
            <h2 class="text-primary">Découvrez nos habitats</h2>
            <p>
                Notre zoo est composé de 3 principaux habitats :
                <strong>Les marais</strong>, <strong>la jungle</strong>, ainsi que <strong>la savane</strong>.
                <br>
                Nous vous invitons à explorer ces environnements recréés avec soin pour offrir aux animaux un habitat respectueux et sécurisé. 
                Notre parc est conscient de l'importance de préserver la biodiversité et œuvre activement pour la conservation des espèces.
            </p>
        </div>
    </div>

    <!-- Titre de la section carrousel -->
    <h1 class="text-center">Liste des habitats</h1>

    <?php if (!empty($habitats)): ?>
        <!-- Carrousel des habitats -->
        <div id="habitatCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($habitats as $index => $habitat): ?>
                    <?php 
                        // Formats d'image supportés
                        $formats = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                        $imagePath = "/ZooArcadia/photos/" . htmlspecialchars($habitat['nom_image']);
                        $imageFound = false;

                        // Vérifie si le fichier existe avec l'un des formats
                        foreach ($formats as $format) {
                            $fullPath = $_SERVER['DOCUMENT_ROOT'] . "/ZooArcadia/photos/" . pathinfo($habitat['nom_image'], PATHINFO_FILENAME) . "." . $format;
                            if (file_exists($fullPath)) {
                                $imagePath = "/ZooArcadia/photos/" . pathinfo($habitat['nom_image'], PATHINFO_FILENAME) . "." . $format;
                                $imageFound = true;
                                break;
                            }
                        }
                    ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="card mx-auto" style="max-width: 600px;">
                            <img 
                                src="<?= $imageFound ? htmlspecialchars($imagePath) : '/ZooArcadia/photos/default_habitat.jpg' ?>" 
                                class="card-img-top" 
                                alt="Image de <?= htmlspecialchars($habitat['nom']) ?>" 
                                style="height: 300px; object-fit: cover;"
                            >
                            <div class="card-body text-center" >
    
    <h5 class="card-title text-primary" style="color: #228b22; ">
                                    <a href="/ZooArcadia/habitats/show/<?= htmlspecialchars($habitat['habitat_id']) ?>">
                                        <?= htmlspecialchars($habitat['nom']) ?>
                                    </a>
                                </h5>
                                <p class="card-text">
                                    <?= htmlspecialchars($habitat['description'] ?? 'Aucune description disponible') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Contrôles du carrousel -->
            <button class="carousel-control-prev" type="button" data-bs-target="#habitatCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#habitatCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>
    <?php else: ?>
        <p class="text-center">Aucun habitat trouvé.</p>
    <?php endif; ?>
</div>
