<?php
require_once __DIR__ . '/../../config/session.php';

// Récupérer les animaux depuis les données passées au template
$animaux = $data['animaux'] ?? [];
?>

<div class="container mt-5">
    <h1 class="text-center">Alimentation des animaux</h1>

    <!-- Historique des repas -->
    <div class="text-center mb-4">
        <a href="/ZooArcadia/employe/historique_nourriture" class="btn btn-secondary">Historique des repas</a>
    </div>

    <!-- Liste des animaux avec recommandations -->
    <?php if (!empty($animaux)): ?>
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>Nom de l'animal</th>
                    <th>Recommandation vétérinaire</th>
                    <th>Date de la recommandation</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($animaux as $animal): ?>
                    <tr>
                        <td><?= htmlspecialchars($animal['prenom']) ?></td>
                        <td>
                            Nourriture : <?= htmlspecialchars($animal['recommandation_nourriture'] ?? 'Non spécifiée') ?><br>
                            Grammage : <?= htmlspecialchars($animal['recommandation_grammage'] ?? 'Non spécifié') ?> g
                        </td>
                        <td>
                            <?= htmlspecialchars($animal['recommandation_date'] ?? 'Non spécifiée') ?>
                        </td>
                        <td>
                            <a href="/ZooArcadia/employe/nourrir/<?= htmlspecialchars($animal['animal_id']) ?>" class="btn btn-primary">Nourrir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center text-muted">Aucun animal disponible.</p>
    <?php endif; ?>
    <a href="/ZooArcadia/employe/dashboard" class="btn btn-primary" style="margin-bottom: 15px;">⬅ Retour à l'espace employé</a>
</div>
