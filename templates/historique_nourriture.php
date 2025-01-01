<?php
require_once __DIR__ . '/../src/Database/Dbutils.php';
use App\Database\Dbutils;

// Connexion à la base de données et récupération des données
$pdo = Dbutils::getPdo();
$stmt = $pdo->query("
    SELECT n.date_time, n.type_nourriture, n.quantite, a.prenom AS animal_prenom 
    FROM nourriture n 
    JOIN animal a ON n.animal_id = a.animal_id 
    ORDER BY n.date_time DESC
");
?>

<h2 class="text-center">Historique des repas des animaux</h2>
<?php if (!empty($data['nourriture'])): ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Date et heure</th>
                <th>Animal</th>
                <th>Type de nourriture</th>
                <th>Quantité</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['nourriture'] as $nourriture): ?>
                <tr>
                    <td><?= htmlspecialchars($nourriture['date_time']) ?></td>
                    <td><?= htmlspecialchars($nourriture['animal_prenom']) ?></td>
                    <td><?= htmlspecialchars($nourriture['type_nourriture']) ?></td>
                    <td><?= htmlspecialchars($nourriture['quantite']) ?> g</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-center text-muted">Aucune donnée trouvée.</p>
<?php endif; ?>

<a href="/ZooArcadia/employe/dashboard" class="btn btn-primary mt-3">⬅ Retour au tableau de bord</a>
