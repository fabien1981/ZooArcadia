<div class="container">
    <h1><?= htmlspecialchars($message ?? ''); ?></h1>

    <?php if (!empty($error)): ?>
        <div class="alert alert-warning" role="alert">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="mb-3">
            <label for="EmailInput" class="form-label">Identifiant</label>
            <input type="email" class="form-control" id="EmailInput" name="email" required>
        </div>
        <div class="mb-3">
            <label for="PasswordInput" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="PasswordInput" name="password" required>
        </div>

        <div class="col-12">
            <button class="btn btn-primary" type="submit" id="btn-validation-connexion" disabled>Connexion</button>
        </div>
    </form>
</div>

<!-- Inclusion du fichier JavaScript externe -->
<script src="/811/scripts/connexion.js"></script>

