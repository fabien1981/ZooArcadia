<div class="container mt-5">
    <h2 class="text-center">Gestion des Avis</h2>

    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success_message']) ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['error_message']) ?>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <h3>Avis non validés</h3>
    <?php if (!empty($data['avisNonValides'])): ?>
        <ul class="list-group">
            <?php foreach ($data['avisNonValides'] as $avis): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($avis['pseudo']) ?></strong>: <?= htmlspecialchars($avis['avis']) ?>
                    <br>
                    Note: <?= str_repeat('★', (int) $avis['rating']) ?>
                    <br>
                    <form action="employe/validate_avis" method="post" class="d-inline">
                        <input type="hidden" name="id" value="<?= $avis['_id'] ?>">
                        <button type="submit" class="btn btn-success btn-sm">Valider</button>
                    </form>
                    <form action="employe/delete_avis" method="post" class="d-inline">
                        <input type="hidden" name="id" value="<?= $avis['_id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun avis non validé.</p>
    <?php endif; ?>

    <h3 class="mt-5">Avis validés</h3>
    <?php if (!empty($data['avisValides'])): ?>
        <ul class="list-group">
            <?php foreach ($data['avisValides'] as $avis): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($avis['pseudo']) ?></strong>: <?= htmlspecialchars($avis['avis']) ?>
                    <br>
                    Note: <?= str_repeat('★', (int) $avis['rating']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun avis validé.</p>
    <?php endif; ?>
</div>
