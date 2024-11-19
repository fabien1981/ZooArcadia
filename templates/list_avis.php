<!DOCTYPE html>
<html>
<head>
    <title>Liste des Avis</title>
</head>
<body>
    <h1>Liste des Avis</h1>
    <?php foreach ($avis as $a) : ?>
        <div>
            <strong>Pseudo :</strong> <?= htmlspecialchars($a['pseudo']) ?><br>
            <strong>Avis :</strong> <?= htmlspecialchars($a['avis']) ?><br>
            <strong>Note :</strong> <?= htmlspecialchars($a['rating']) ?>/5<br>
            <a href="/delete_avis.php?id=<?= $a['_id'] ?>">Supprimer</a>
            <hr>
        </div>
    <?php endforeach; ?>
</body>
</html>
