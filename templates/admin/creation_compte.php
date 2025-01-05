
<div class="container">
<a href="/ZooArcadia/admin/display" class="btn btn-secondary mb-3">Retour à l'admin</a>

    <h2>Créer un compte utilisateur</h2>

    <div id="response-message" class="alert" role="alert" style="display: none;"></div>

    <form id="creation-compte-form" action="/ZooArcadia/admin/creer_compte" method="POST" novalidate>

        <!-- Champs du formulaire -->
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
            <div class="invalid-feedback">Veuillez entrer un nom.</div>
        </div>
        
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
            <div class="invalid-feedback">Veuillez entrer un prénom.</div>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Rôle</label>
            <select class="form-control" id="role" name="role" required>
                <option value="">Sélectionnez un rôle</option>
                <option value="Employé">Employé</option>
                <option value="Vétérinaire">Vétérinaire</option>
            </select>
            <div class="invalid-feedback">Veuillez sélectionner un rôle.</div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
            <div class="invalid-feedback">Veuillez entrer une adresse email valide.</div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <div class="invalid-feedback">Veuillez entrer un mot de passe.</div>
        </div>

        <button type="submit" class="btn btn-primary">Créer le compte</button>
    </form>
</div>
