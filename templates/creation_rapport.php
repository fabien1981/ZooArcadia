<?php
require_once __DIR__ . '/../config/session.php';

if (!isset($_SESSION['email']) || $_SESSION['email']['role'] !== 'Vétérinaire') {
    header('Location: /connexion/display');
    exit;
}

$animal = $data['animal'] ?? null;

if (!$animal): ?>
    <div class="alert alert-danger">Animal introuvable.</div>
    <a href="/veterinaire/display" class="btn btn-secondary">Retour</a>
    <?php exit; ?>
<?php endif; ?>

<div class="container mt-5">
    <h1>Créer un rapport vétérinaire pour <?= htmlspecialchars($animal['prenom']) ?></h1>

    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success_message']; ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error_message']; ?>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <form method="POST" action="/api/veterinaire/createReport">
        <input type="hidden" name="animal_id" value="<?= htmlspecialchars($animal['animal_id']) ?>">

    <div class="mb-3">
        <label for="etat" class="form-label">État</label>
        <select id="etat" name="etat" class="form-select" required>
            <option value="">Sélectionnez l'état</option>
            <option value="Fatigué">Fatigué</option>
            <option value="Correct">Correct</option>
            <option value="Bon">Bon</option>
            <option value="En super forme">En super forme</option>
        </select>
    </div>

    <div class="mb-3">
            <label for="nourriture" class="form-label">Nourriture</label>
            <input type="text" id="nourriture" name="nourriture" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="grammage" class="form-label">Grammage</label>
            <input type="text" id="grammage" name="grammage" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="detail" class="form-label">Détail</label>
            <textarea id="detail" name="detail" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Créer le rapport</button>
        <a href="/veterinaire/display" class="btn btn-secondary">Annuler</a>
    </form>

<script>
document.getElementById('formulaireRapport').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);
    const data = {
        animal_id: formData.get('animal_id'),
        etat: formData.get('etat'),
        nourriture: formData.get('nourriture'),
        grammage: formData.get('grammage'),
        detail: formData.get('detail'),
    };

    console.log('Données envoyées :', data); // Debug

    fetch('/api/veterinaire/createReport', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
        .then(response => response.json())
        .then(result => {
            console.log('Réponse de l\'API :', result); // Debug
            if (result.success) {
                alert(result.message);
                window.location.href = '/veterinaire/display';
            } else {
                alert(result.message);
            }
        })
        .catch(error => console.error('Erreur lors de la création du rapport :', error));
});



</script>
