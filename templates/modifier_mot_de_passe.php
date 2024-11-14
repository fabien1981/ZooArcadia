<?php

if (!isset($_SESSION['email'])) {
    header('Location: /ZooArcadia/connexion/display');
    exit;
}

// Variables pour stocker les messages de succès ou d'erreur
$error = $error ?? null;
$success = $success ?? null;
?>

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
            <label for="current_password" class="form-label">Mot de passe actuel</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label">Nouveau mot de passe</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Modifier le mot de passe</button>
    </form>
</div>
