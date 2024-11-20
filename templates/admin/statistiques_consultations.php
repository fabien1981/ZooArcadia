<div class="container">
    <h1>Statistiques des Consultations</h1>
    <?php if (!empty($stats)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom de l'animal</th>
                    <th>Habitat</th>
                    <th>Nombre de consultations</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($stats as $stat): ?>
        <tr>
            <td><?= htmlspecialchars($stat['animal_name'] ?? 'Nom inconnu') ?></td>
            <td><?= htmlspecialchars($stat['habitat_name'] ?? 'Habitat inconnu') ?></td>
            <td><?= htmlspecialchars($stat['consultations'] ?? 0) ?></td>
        </tr>
    <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune donnée disponible.</p>
    <?php endif; ?>
</div>

