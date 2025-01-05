<?php
require_once __DIR__ . '/../src/Database/Dbutils.php';
use App\Database\Dbutils;

// Récupérer les données transmises depuis le contrôleur
$nourriture = $data['nourriture'] ?? []; // Utiliser une liste vide par défaut
?>

<h2 class="text-center">Historique des repas des animaux</h2>

<?php if (!empty($nourriture)): ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Date et heure</th>
                <th>Animal</th>
                <th>Type de nourriture</th>
                <th>Quantité</th>
                <th>Enregistré par</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nourriture as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['date_time']); ?></td>
                    <td><?= htmlspecialchars($row['animal_prenom']); ?></td>
                    <td><?= htmlspecialchars($row['type_nourriture']); ?></td>
                    <td><?= htmlspecialchars($row['quantite']); ?> g</td>
                    <td><?= htmlspecialchars($row['user_prenom'] . ' ' . $row['user_nom']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-center text-muted">Aucune donnée trouvée.</p>
<?php endif; ?>

<a href="/ZooArcadia/employe/alimentation" class="btn btn-primary mt-3">⬅ Retour à la page alimentation</a>
