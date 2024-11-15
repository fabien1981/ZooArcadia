<?php
require_once __DIR__ . '/../src/Database/Dbutils.php'; // ajustez le chemin si nécessaire
use App\Database\Dbutils;

// Connexion à la base de données via Dbutils
$pdo = Dbutils::getPdo();

// Récupération des données
$stmt = $pdo->query("SELECT n.date_time, n.type_nourriture, n.quantite, a.prenom AS animal_prenom FROM nourriture n JOIN animal a ON n.animal_id = a.animal_id ORDER BY n.date_time DESC");
?>



<h2>Historique des repas des animaux</h2>

<table border="1">
    <tr>
        <th>Date et heure</th>
        <th>Animal</th>
        <th>Type de nourriture</th>
        <th>Quantité</th>
    </tr>
    <?php while ($nourriture = $stmt->fetch()): ?>
        <tr>
            <td><?php echo htmlspecialchars($nourriture['date_time']); ?></td>
            <td><?php echo htmlspecialchars($nourriture['animal_prenom']); ?></td>
            <td><?php echo htmlspecialchars($nourriture['type_nourriture']); ?></td>
            <td><?php echo htmlspecialchars($nourriture['quantite']); ?></td>
        </tr>
    <?php endwhile; ?>
</table>

