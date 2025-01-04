<div class="hero-scene text-center text-white">
    <div class="hero-scene-content">
        <p>Contact</p>
    </div>
</div>

<div class="container mt-5">
    <h2 class="text-center mb-4">Nous contacter</h2>

    <!-- Affichage des messages de confirmation ou d'erreur -->
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success_message']); ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['error_message']); ?>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- Formulaire de contact -->
    <form method="POST" action="contact/handleContactForm">
        <div class="mb-3">
            <label for="TitreInput" class="form-label">Titre</label>
            <input 
                type="text" 
                class="form-control" 
                id="TitreInput" 
                name="titre" 
                placeholder="Titre de votre demande." 
                required>
            <div class="invalid-feedback">
                Un titre est requis !
            </div>
        </div>
        
        <div class="mb-3">
            <label for="EmailInput" class="form-label">Email</label>
            <input 
                type="email" 
                class="form-control" 
                id="EmailInput" 
                name="email" 
                placeholder="exemple@mail.fr" 
                required>
            <div class="invalid-feedback">
                Le mail n'est pas au bon format !
            </div>
        </div>
        
        <div class="mb-3">
            <label for="DescriptionInput" class="form-label">Description</label>
            <textarea 
                class="form-control" 
                id="DescriptionInput" 
                name="description" 
                rows="3" 
                placeholder="Écrivez votre demande ici." 
                required></textarea>
            <div class="invalid-feedback">
                Un texte est requis !
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary" id="btn-validation-contact">Envoyer</button>
    </form>
</div>
