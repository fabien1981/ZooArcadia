<?php if (isset($data['animal'])): ?>
    <h2 class="text-center mt-5">Nourrir <?= htmlspecialchars($data['animal']['prenom']) ?></h2>
    <form action="/ZooArcadia/employe/add_nourriture" method="POST" class="mt-4">
        <input type="hidden" name="animal_id" value="<?= htmlspecialchars($data['animal']['animal_id']) ?>">
        <div class="form-group">
            <label for="date_time">Date et Heure :</label>
            <input type="datetime-local" id="date_time" name="date_time" class="form-control" required>
        </div>
        <div class="form-group mt-3">
            <label for="type_nourriture">Type de Nourriture :</label>
            <input type="text" id="type_nourriture" name="type_nourriture" class="form-control" required>
        </div>
        <div class="form-group mt-3">
            <label for="quantite">Quantité (grammes) :</label>
            <input type="number" id="quantite" name="quantite" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
    </form>
<?php else: ?>
    <p class="text-danger">Aucun animal sélectionné pour nourrir.</p>
<?php endif; ?>
