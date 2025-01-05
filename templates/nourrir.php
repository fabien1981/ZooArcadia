<?php
$animal = $data['animal'] ?? null;
?>
<?php if (!empty($animal)): ?>
    <div class="container mt-5">
        <h2 class="text-center">Nourrir <?= htmlspecialchars($animal['prenom']); ?></h2>
        <p class="text-center">
            <strong>Recommandation vétérinaire :</strong><br>
            Nourriture : <?= htmlspecialchars($animal['recommandation_nourriture'] ?? 'Non spécifiée'); ?><br>
            Quantité : <?= htmlspecialchars($animal['recommandation_grammage'] ?? 'Non spécifiée'); ?> g
        </p>

        <form action="/employe/add_nourriture" method="POST" class="mt-4">
    <input type="hidden" name="animal_id" value="<?= htmlspecialchars($animal['animal_id']); ?>">
    <input type="hidden" name="user_id" value="<?= isset($_SESSION['email']['user_id']) ? htmlspecialchars($_SESSION['email']['user_id']) : ''; ?>">

    
    <div class="form-group">
        <label for="date_time">Date et Heure :</label>
        <input type="datetime-local" id="date_time" name="date_time" class="form-control" required>
    </div>
    
    <div class="form-group mt-3">
        <label for="type_nourriture">Type de Nourriture :</label>
        <input type="text" id="type_nourriture" name="type_nourriture" class="form-control" 
               value="<?= htmlspecialchars($animal['recommandation_nourriture'] ?? ''); ?>" required>
    </div>
    
    <div class="form-group mt-3">
        <label for="quantite">Quantité (grammes) :</label>
        <input type="number" id="quantite" name="quantite" class="form-control" 
               value="<?= htmlspecialchars($animal['recommandation_grammage'] ?? ''); ?>" required>
    </div>
    
    <button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
</form>

    </div>
<?php else: ?>
    <div class="container mt-5">
        <p class="text-danger">Aucun animal sélectionné pour nourrir.</p>
    </div>
<?php endif; ?>

<a href="/employe/alimentation" class="btn btn-primary mt-3">⬅ Retour à la page alimentation</a>
