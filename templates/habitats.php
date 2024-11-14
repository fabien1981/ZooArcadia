<?php if (isset($animauxParHabitat, $descriptions)): ?>
    <div class="container">
        <h1 class="text-center mt-5">Nos Habitats</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
            <?php foreach ($animauxParHabitat as $habitat => $animaux): ?>
                <div class="col">
                    <div class="card habitat-card" onclick="toggleDetails('<?php echo $habitat; ?>')">
                        <img src="../photos/<?php echo strtolower($habitat); ?>.jpeg" class="card-img-top" alt="<?php echo htmlspecialchars($habitat); ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($habitat); ?></h5>
                        </div>
                    </div>

                    <!-- Détails de l'habitat affichés au clic -->
                    <div class="habitat-details mt-3" id="details-<?php echo htmlspecialchars($habitat); ?>" style="display: none;">
                        <p><?php echo htmlspecialchars($descriptions[$habitat] ?? 'Description indisponible'); ?></p>
                        <h6>Animaux présents :</h6>
                        <ul>
                            <?php foreach ($animaux as $animal): ?>
                                <li><?php echo htmlspecialchars($animal['race']); ?> - Prénom : <?php echo htmlspecialchars($animal['prenom']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        function toggleDetails(habitat) {
            const detailsDiv = document.getElementById('details-' + habitat);
            const isVisible = detailsDiv.style.display === 'block';
            document.querySelectorAll('.habitat-details').forEach(div => div.style.display = 'none');
            detailsDiv.style.display = isVisible ? 'none' : 'block';
        }
    </script>
<?php else: ?>
    <p>Aucune donnée disponible pour les habitats.</p>
<?php endif; ?>
