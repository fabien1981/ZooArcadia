

<div class="container">
    <h1>Modifier le mot de passe</h1>

    <?php if (!empty($error)): ?>
        <div class="alert alert-warning" role="alert">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="mb-3">
            <label for="mot_de_passe_actuel" class="form-label">Mot de passe actuel</label>
            <input type="password" class="form-control" id="mot_de_passe_actuel" name="mot_de_passe_actuel" required>
        </div>
        <div class="mb-3">
            <label for="nouveau_mot_de_passe" class="form-label">Nouveau mot de passe</label>
            <input type="password" class="form-control" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" required>
        </div>
        <div class="mb-3">
            <label for="confirmation_mot_de_passe" class="form-label">Confirmer le nouveau mot de passe</label>
            <input type="password" class="form-control" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" required>
        </div>
        <button type="submit" class="btn btn-primary">Modifier le mot de passe</button>
    </form>
</div>
