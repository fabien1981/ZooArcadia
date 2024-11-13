<div class="container">
    <h1>Tableau de bord administrateur</h1>

    <!-- Affichage du message de confirmation de création de compte -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION['success_message']; ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <a href="/811/admin/creation-compte" class="btn btn-primary">Créer un compte utilisateur</a>
    <a href="/811/admin/gestion-animaux" class="btn btn-primary">Gestion des animaux</a>
</div>
