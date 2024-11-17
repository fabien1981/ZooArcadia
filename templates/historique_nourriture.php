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
<?php if ($stmt->rowCount() > 0): ?>
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
            <?php while ($nourriture = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($nourriture['date_time']); ?></td>
                    <td><?php echo htmlspecialchars($nourriture['animal_prenom']); ?></td>
                    <td><?php echo htmlspecialchars($nourriture['type_nourriture']); ?></td>
                    <td><?php echo htmlspecialchars($nourriture['quantite']); ?> g</td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-center text-muted">Aucune donnée trouvée.</p>
<?php endif; ?>
