<div class="container">
    <h1>Tableau de bord administrateur</h1>

    <!-- Affichage du message de confirmation de création de compte -->
    <?php
    require_once __DIR__ . '/../config/session.php';
     if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION['success_message']; ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <a href="/ZooArcadia/admin/creation_compte" class="btn btn-primary">Créer un compte utilisateur</a>
    <a href="/ZooArcadia/admin/gestion_animaux" class="btn btn-primary">Gestion des animaux</a>
    <a href="/ZooArcadia/admin/gestion_horaires" class="btn btn-primary">Gestion des horaires</a>



</div>
